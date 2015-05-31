/**
 * Created by davidcontavalli on 30/05/15.
 */
"use strict";

angular.module('dream-beach', [
    'ngResource',
    'ngRoute',
    'ui.bootstrap',
    'ngFileUpload'
]).config([
    '$interpolateProvider', function ($interpolateProvider) {
        return $interpolateProvider.startSymbol('{(').endSymbol(')}');
    }
]);
