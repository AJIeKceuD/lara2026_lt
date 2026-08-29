#!/bin/bash

# Создаём временный файл
temp_file=$(mktemp)

# Ищем все вызовы __() в PHP и Blade файлах
grep -rh --include="*.php" --include="*.blade.php" -E "__\(['\"]([^'\"]+)['\"]\)" . | \
    sed -E "s/.*__\(['\"]([^'\"]+)['\"].*/\1/" | \
    sort -u > "$temp_file"

# Создаём JSON файл
echo "{" > lang/en.json
first=true

while IFS= read -r line; do
    if [ -n "$line" ]; then
        if [ "$first" = true ]; then
            first=false
        else
            echo "," >> lang/en.json
        fi
        echo "    \"$line\": \"$line\"" >> lang/en.json
    fi
done < "$temp_file"

echo "}" >> lang/en.json

# Удаляем временный файл
rm "$temp_file"

echo "✅ Translations collected to resources/lang/en.json"
