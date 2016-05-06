var apiManager = {

    makeCall: function (entity, action, params, callback, errorHandler) {
        this.resolveEndpoint(entity, action, params, function (final) {
            callback(final);
        }, function(error) {
            if (errorHandler != undefined) errorHandler(error);
        });
    },

    callEndPoint: function (endpoint, params, callback, error) {
        // replace params in the url if necessary
        var finalParams = {};
        $.each(params, function(index, val) {
            if (endpoint.endpoint.indexOf('*' + index + '*') !== -1) {
                endpoint.endpoint = endpoint.endpoint.replace('*' + index + '*', val);
            }
            else {
                finalParams[index] = val;
            }
        });

        $.ajax({
            url: endpoint.endpoint,
            data: finalParams,
            dataType: 'json',
            method: endpoint.method,
            success: function(response) {
                callback(response);
            },
            error: function(response) {
                error('Error with API Endpoint', endpoint, response);
            },
            statusCode: {
                404: function() {
                    error('API 404: ' + endpoint.endpoint)
                }
            }
        });
    },

    resolveEndpoint: function (entity, action, params, callback, error) {
        var _this = this;
        this.getEndpoints(function (response) {
            var ok = false;
            $.each(response.data, function (index, val) {
                if (index == entity) {
                    $.each(val, function (index, endpoint) {
                        if (index == action) {
                            _this.callEndPoint(endpoint, params, callback, error);
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
            if (sessionObject && sessionObject.when && parseInt(new Date(sessionObject.when).getTime()) + 30000 > parseInt(new Date().getTime())) {
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