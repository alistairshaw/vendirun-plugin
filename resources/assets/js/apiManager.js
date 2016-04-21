var apiManager = {

    makeCall: function(entity, action) {
        this.getEndpoints(function(response) {
            $.each(response, function(val) {
                console.log(val);
            });
        });
    },

    getEndpoints: function(callback) {
        $.get('/api', function(response) {
            callback(response);
        }, 'json');
    }

};