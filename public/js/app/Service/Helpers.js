/**
 * Created by davidcontavalli on 02/06/15.
 */
/**
 * Created by davidcontavalli on 02/06/15.
 */
'use strict';

angular.module('dream-beach')
    .factory('Helpers', ['$location',function ($location) {
        return {

            formatDateTime: function(dateTime){
                var dateTimePart = dateTime.split(' ');
                var date = dateTimePart[0];
                var time = dateTimePart[1];
                return date.split('/').reverse().join('-') + time;
            },

            getEndPoint: function(){
                var hostname = $location.host();
                var environment;

                if (hostname.indexOf("stage") >= 0) {
                    environment = "stage.";
                } else if (hostname.indexOf("dev") >= 0) {
                    environment = "dev.";
                } else {
                    environment = "";
                }
                return "http://api." + environment + hostname;
            }
        };
    }]);
