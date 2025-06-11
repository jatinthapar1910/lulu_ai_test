const { createApp, ref, onMounted } = Vue;

const app = {
    setup() {
        const tickets = ref([]);
        const loading = ref(false);
        const form = ref({ subject: '', body: '' });
        const search = ref('');

        const fetchTickets = async () => {
            const response = await fetch(`/api/tickets?search=${encodeURIComponent(search.value)}`);
            tickets.value = await response.json();
        };

        const createTicket = async () => {
            await fetch('/api/tickets', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(form.value)
            });
            form.value.subject = '';
            form.value.body = '';
            await fetchTickets();
        };

        const classify = async (id) => {
            loading.value = id;
            await fetch(`/api/tickets/${id}/classify`, { method: 'POST' });
            await fetchTickets();
            loading.value = false;
        };

        onMounted(fetchTickets);

        return { tickets, form, search, fetchTickets, createTicket, classify, loading };
    }
};

createApp(app).mount('#app');
