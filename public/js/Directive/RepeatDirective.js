app.directive('myRepeatDirective', function($timeout) 
{
    return function(scope, element, attrs) 
    {
        if (element.is("option")) 
        {
            $timeout(function() {
                $('select').material_select();
            });  
        }
    };
});