/**
 * back to top directive
 */
angular.module('asreApp').directive('backToTop', function ()
{
    return {
        link: function ($scope, element)
        {
            element.on('click', function(){
                $("html, body").animate({
                    scrollTop: 0
                }, 600);
                return false;
            })
        }
    };
})
