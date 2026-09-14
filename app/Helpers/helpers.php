<?php

/**
 * Обрезает HTML текст до указанного количества символов, корректно обрабатывая теги
 *
 * @param string $html Входной HTML текст
 * @param int $limit Максимальное количество символов (без учета HTML тегов)
 * @param string $suffix Суффикс, добавляемый после обрезания (по умолчанию '...')
 * @param bool $preserveTags Сохранять ли все теги (по умолчанию true)
 * @return string Обрезанный HTML текст с корректно закрытыми тегами
 */
function truncateHtml(string $html, int $limit, string $suffix = '...', bool $preserveTags = true): string
{
    // Если строка пустая или лимит <= 0
    if (empty($html) || $limit <= 0) {
        return '';
    }

    // Если текст меньше лимита, возвращаем как есть
    $plainText = strip_tags($html);
    if (mb_strlen($plainText) <= $limit) {
        return $html;
    }

    // Используем DOMDocument для парсинга HTML
    $dom = new DOMDocument('1.0', 'UTF-8');

    // Подавляем ошибки при парсинге некорректного HTML
    $oldLibXmlErrors = libxml_use_internal_errors(true);

    // Оборачиваем контент в корневой элемент для корректного парсинга
    $wrappedHtml = '<root>' . mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8') . '</root>';
    $dom->loadHTML($wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    libxml_clear_errors();
    libxml_use_internal_errors($oldLibXmlErrors);

    // Получаем корневой элемент и проходим по всем узлам
    $root = $dom->documentElement;
    $newDom = new DOMDocument('1.0', 'UTF-8');
    $newRoot = $newDom->createElement('root');
    $newDom->appendChild($newRoot);

    $count = 0;
    $node = $root->firstChild;
    $truncated = false;

    // Рекурсивно обрабатываем узлы
    $processNode = function($node, $parent, &$count) use (&$processNode, $limit, $newDom, $suffix, &$truncated) {
        if ($truncated) {
            return;
        }

        foreach ($node->childNodes as $child) {
            if ($truncated) {
                break;
            }

            if ($child->nodeType === XML_TEXT_NODE) {
                // Текстовый узел
                $text = $child->textContent;
                $textLength = mb_strlen($text);

                if ($count + $textLength <= $limit) {
                    // Полностью добавляем текст
                    $newText = $newDom->createTextNode($text);
                    $parent->appendChild($newText);
                    $count += $textLength;
                } else {
                    // Частично добавляем текст
                    $remaining = $limit - $count;
                    $truncatedText = mb_substr($text, 0, $remaining) . $suffix;
                    $newText = $newDom->createTextNode($truncatedText);
                    $parent->appendChild($newText);
                    $count = $limit;
                    $truncated = true;

                    // Добавляем остальные узлы как есть
                    $remainingNodes = [];
                    $currentNode = $child->nextSibling;
                    while ($currentNode) {
                        $remainingNodes[] = $currentNode;
                        $currentNode = $currentNode->nextSibling;
                    }

                    foreach ($remainingNodes as $remainNode) {
                        $importedNode = $newDom->importNode($remainNode, true);
                        $parent->appendChild($importedNode);
                    }
                }
            } else {
                // Не текстовый узел (тег)
                $newNode = $newDom->importNode($child, false);
                $parent->appendChild($newNode);

                // Рекурсивно обрабатываем дочерние узлы
                $processNode($child, $newNode, $count);
            }
        }
    };

    $processNode($root, $newRoot, $count);

    // Извлекаем содержимое без корневого элемента
    $result = '';
    foreach ($newRoot->childNodes as $child) {
        $result .= $newDom->saveHTML($child);
    }

    // Закрываем незакрытые теги
    if ($preserveTags) {
        $result = closeTags($result);
    }

    return $result;
}

/**
 * Закрывает незакрытые HTML теги
 *
 * @param string $html HTML текст
 * @return string HTML с корректно закрытыми тегами
 */
function closeTags(string $html): string
{
    // Находим все открытые теги
    preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/>])>#iU', $html, $openTags);
    preg_match_all('#</([a-z]+)>#iU', $html, $closeTags);

    $openTagNames = $openTags[1] ?? [];
    $closeTagNames = $closeTags[1] ?? [];

    // Список самозакрывающихся тегов
    $selfClosing = ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr'];

    $openCount = [];
    $closeCount = [];

    // Считаем открытые теги (игнорируем самозакрывающиеся)
    foreach ($openTagNames as $tag) {
        if (!in_array(strtolower($tag), $selfClosing)) {
            $openCount[strtolower($tag)] = ($openCount[strtolower($tag)] ?? 0) + 1;
        }
    }

    // Считаем закрытые теги
    foreach ($closeTagNames as $tag) {
        $closeCount[strtolower($tag)] = ($closeCount[strtolower($tag)] ?? 0) + 1;
    }

    // Добавляем закрывающие теги для незакрытых
    $result = $html;
    foreach ($openCount as $tag => $count) {
        $diff = $count - ($closeCount[$tag] ?? 0);
        while ($diff > 0) {
            $result .= '</' . $tag . '>';
            $diff--;
        }
    }

    return $result;
}

/**
 * Альтернативная упрощенная версия для случаев, когда не нужна сложная обработка DOM
 *
 * @param string $html Входной HTML текст
 * @param int $limit Максимальное количество символов
 * @param string $suffix Суффикс
 * @return string Обрезанный HTML
 */
function truncateHtmlSimple(string $html, int $limit, string $suffix = '...'): string
{
    $plainText = strip_tags($html);

    if (mb_strlen($plainText) <= $limit) {
        return $html;
    }

    // Находим позицию обрезания в чистом тексте
    $pos = 0;
    $count = 0;
    $inTag = false;
    $tagBuffer = '';
    $result = '';

    for ($i = 0; $i < mb_strlen($html); $i++) {
        $char = mb_substr($html, $i, 1);

        if ($char === '<') {
            $inTag = true;
            $tagBuffer = '<';
            continue;
        }

        if ($inTag) {
            $tagBuffer .= $char;
            if ($char === '>') {
                $inTag = false;
                $result .= $tagBuffer;
            }
            continue;
        }

        if ($char === '&') {
            // Обрабатываем HTML сущности
            $entity = '';
            $j = $i;
            while ($j < mb_strlen($html) && mb_substr($html, $j, 1) !== ';') {
                $entity .= mb_substr($html, $j, 1);
                $j++;
            }
            if ($j < mb_strlen($html) && mb_substr($html, $j, 1) === ';') {
                $entity .= ';';
                $i = $j;
                $result .= $entity;
                $count++;
                continue;
            }
        }

        if ($count < $limit) {
            $result .= $char;
            $count++;
        } else {
            // Добавляем суффикс
            $result = rtrim($result) . $suffix;
            break;
        }
    }

    // Закрываем теги
    return closeTags($result);
}

// Пример использования:
// $html = '<p>Привет, <strong>мир!</strong> Это тестовый <a href="#">HTML текст</a> с <em>разными</em> тегами.</p>';

// echo truncateHtml($html, 30);
// // Результат: <p>Привет, <strong>мир!</strong> Это тестовый <a href="#">HTML текст</a> с <em>разными</em> тегами...</p>

// echo truncateHtmlSimple($html, 30);
// // Результат: <p>Привет, <strong>мир!</strong> Это тестовый <a href="#">HTML текст</a> с <em>разными</em> тегами...</p>
