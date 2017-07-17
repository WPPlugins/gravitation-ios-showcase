jQuery(document).ready(function($) {
	
	 jQuery("#slider2").responsiveSlides({
        auto: false,
        pager: true,
        speed: 300,
        maxwidth: 320
      });
	

	
	
	
	// Setting up our variables
    var $filter;
    var $container;
    var $containerClone;
    var $filterLink;
    var $filteredItems
     
    // Set our filter
    $filter = $('.filterOptions li.active a').attr('class');
     
    // Set our filter link
    $filterLink = $('.filterOptions li a');
     
    // Set our container
    $container = $('ul.ourHolder');
     
    // Clone our container
    $containerClone = $container.clone();
  
    // Apply our Quicksand to work on a click function
    // for each of the filter li link elements
    $filterLink.click(function(e) 
    {
        // Remove the active class
        $('.filterOptions li').removeClass('active');
         
        // Split each of the filter elements and override our filter
        $filter = $(this).attr('class').split(' ');
         
        // Apply the 'active' class to the clicked link
        $(this).parent().addClass('active');
         
        // If 'all' is selected, display all elements
        // else output all items referenced by the data-type
        if ($filter == 'all') {
            $filteredItems = $containerClone.find('li'); 
        }
        else {
            $filteredItems = $containerClone.find('li[data-type~=' + $filter + ']'); 
        }
         
        // Finally call the Quicksand function
        $container.quicksand($filteredItems, 
        {
            // The duration for the animation
            duration: 750,
            // The easing effect when animating
            easing: 'easeInOutCirc',
            // Height adjustment set to dynamic
            adjustHeight: 'dynamic'
        });
    });
    
    
	//quicksand
    // get the action filter option item on page load
	var $filterType = $('#filterOptions li.active a').attr('class');

	  // get and assign the ourHolder element to the
	  // $holder varible for use later
	  var $holder = $('ul.ourHolder');
	
	  // clone all items within the pre-assigned $holder element
	  var $data = $holder.clone();
	
	  // attempt to call Quicksand when a filter option
	  // item is clicked
	  $('#filterOptions li a').click(function(e) {
	    // reset the active class on all the buttons
	    $('#filterOptions li').removeClass('active');
	
	    // assign the class of the clicked filter option
	    // element to our $filterType variable
	    var $filterType = $(this).attr('class');
	    $(this).parent().addClass('active');
	    if ($filterType == 'all') {
	      // assign all li items to the $filteredData var when
	      // the 'All' filter option is clicked
	      var $filteredData = $data.find('li');
	    }
	    else {
	      // find all li elements that have our required $filterType
	      // values for the data-type element
	      var $filteredData = $data.find('li[data-type=' + $filterType + ']');
	    }
	
	    // call quicksand and assign transition parameters
	    $holder.quicksand($filteredData, {
	      duration: 800,
	      easing: 'easeInOutQuad'
	    });
	    return false;
	  });  
	 
	 
	 


	 
	  
});