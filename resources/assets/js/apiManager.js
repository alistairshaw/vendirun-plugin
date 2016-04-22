var apiManager = {

    makeCall: function (entity, action, params, callback, errorHandler) {
        this.resolveEndpoint(entity, action, params, function (final) {
            callback(final);
        }, function(error) {
            if (errorHandler != undefined) errorHandler(error);
        });
    },

    callEndPoint: function (endpoint, params, callback) {
        $.post(endpoint.endpoint, params, function(response) {
            callback(response);
        }, 'json');
    },

    resolveEndpoint: function (entity, action, params, callback, error) {
        var _this = this;
        this.getEndpoints(function (response) {
            var ok = false;
            $.each(response.data, function (index, val) {
                if (index == entity) {
                    $.each(val, function (index, endpoint) {
                        if (index == action) {
                            _this.callEndPoint(endpoint, params, callback);
                            ok = true;
                        }
                    });
                }
            });
            if (!ok) {
                error('No valid endpoint found for ' + entity + '/' + action);
                sessionStorage.apiEndPoints = null; // in case the reason no endpoint found is because of cached values
            }
        });
    },

    getEndpoints: function (callback) {
        if (sessionStorage.apiEndPoints) {
            var sessionObject = JSON.parse(sessionStorage.apiEndPoints);
            if (sessionObject && sessionObject.when && parseInt(new Date(sessionObject.when).getTime()) + 3000 > parseInt(new Date().getTime())) {
                callback(sessionObject.data);
                return true;
            }
        }

        $.get('/api', function (response) {
            sessionStorage.apiEndPoints = JSON.stringify({
                when: new Date(),
                data: response
            });
            callback(response);
        }, 'json');
    }

};