Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_token').getAttribute('value');

new Vue({
    el: '#statuses5',

    data: {
        newStatus: { text: '' },
    },


    ready: function() {
        this.fetchStatuses();
    },

    methods: {
        fetchStatuses: function() {
            this.$http.get('/status', function(statuses) {
                this.$set('statuses', statuses);
            });
        },

        onSubmitForm: function(e) {
            e.preventDefault();
            var status = this.newStatus;

            this.statuses.push(status);
            this.newStatus = { text: '' };

            this.$http.post('/status', status);
        }
    }
});

