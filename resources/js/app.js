import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.store('contactModal', {
    open: false,
    toggle() {
        this.open = !this.open;
    },
    openModal() {
        this.open = true;
    },
    closeModal() {
        this.open = false;
    }
});

Alpine.data('contactForm', () => ({
    sending: false,
    success: false,
    form: { name: '', email: '', message: '' },
    errors: {},
    async submitForm() {
        console.log('submitForm called');
        console.log('Form data:', this.form);

        this.sending = true;
        this.errors = {};
        this.success = false;

        try {
            const url = window.location.origin + '/contact-us';
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(this.form),
            });

            const data = await response.json();

            if (response.ok) {
                this.success = true;
                this.form = { name: '', email: '', message: '' };
                setTimeout(() => {
                    this.success = false;
                    Alpine.store('contactModal').closeModal();
                }, 2500);
            } else if (data.errors) {
                this.errors = data.errors;
            } else {
                alert(data.message || 'Error');
            }
        } catch (error) {
            console.error('Fetch error:', error);
            console.error('Error message:', error.message);
            console.error('Error stack:', error.stack);
            alert('Network error. Please check your connection.');
        } finally {
            this.sending = false;
        }
    }
}));

Alpine.start();