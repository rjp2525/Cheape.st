var toggleClass = function() {
    var link = function(scope, element, attrs) {
        element.bind('click', function() {
            angular.element('li.active').removeClass('active')
            
            element.toggleClass(attrs.toggleClass)
        })
    }
    
    var directive = {
        link: link,
        restrict: 'EA'
    }
    
    return directive
}

angular
    .module('Cheapest')
    .directive('toggleClass', [
        toggleClass
    ])