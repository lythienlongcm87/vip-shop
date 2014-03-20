/**
 * MoWebSo Library
 *
 * The MoWebSo Is The Foundation For All MoWebSo Extensions
 *
 * @package 	    Backend / Library
 * @author 		    MoWebSo.com / Eugen Stranz
 * @copyright       (C) 2009 - 2013 ENYtheme e.K.
 */

;(function(jQuery) {
	
	jQuery.fn.moduleGrid = function(arg) {
		
		var options = jQuery.extend({}, jQuery.fn.moduleGrid.defaults, arg);
		
		return this.each(function() {
			
			// Define 'this'
			var thisElement = jQuery(this);
			
			gridChanger(options, thisElement);

			console.log(options.gridStructures);
			
		});
	};
	
	function buildSlider(options, obj) {

		var sliderContainer = obj.find('div#slider');
		var inputField = obj.find(':input');
		
		// We Need This To Avoid Conflict With Mootools Slide Event
		sliderContainer[0].slide = null;
		
		sliderContainer.slider({
			value:	options.preSavedGrid['slider'][options.currentGridChangerIndex],
			min: 	options.sliderMin,
			max: 	options.sliderMax,
			step: 	options.sliderStep,
			slide: 	function( event, ui ) {
						
						// Update The Value For Building The Right Grid Visualization
						options.sliderValue = ui.value;
						console.log(options.sliderValue);

						// Building Grid Visualization
						buildingGridVisualization(options, obj);
						
						// Updates The Value Of Input Field
						inputField.val( generateValueArray(options) );
					}
		});
		
		// Start Value On Page loading For Input Field
		inputField.val();

		
	}
	
	
	function generateValueArray(options) {
		options.gridArray[0] = options.currentGridChangerIndex;
		options.gridArray[1] = 1 + ':' + 12 + '||' + 1 + ';';
		options.gridArray[12] = 12 + ':' + 12 + '||' + 1 + ';';
	
		// PreDifend Information On Page Load
		options.gridArray[2] = 2 + ':' + options.preSavedGrid[2] + '||' + options.preSavedGrid['slider'][2] + ';';
		options.gridArray[3] = 3 + ':' + options.preSavedGrid[3] + '||' + options.preSavedGrid['slider'][3] + ';';
		options.gridArray[4] = 4 + ':' + options.preSavedGrid[4] + '||' + options.preSavedGrid['slider'][4] + ';';
		options.gridArray[5] = 5 + ':' + options.preSavedGrid[5] + '||' + options.preSavedGrid['slider'][5] + ';';
		options.gridArray[6] = 6 + ':' + options.preSavedGrid[6] + '||' + options.preSavedGrid['slider'][6] + ';';
		options.gridArray[7] = 7 + ':' + options.preSavedGrid[7] + '||' + options.preSavedGrid['slider'][7] + ';';
		options.gridArray[8] = 8 + ':' + options.preSavedGrid[8] + '||' + options.preSavedGrid['slider'][8] + ';';
		options.gridArray[9] = 9 + ':' + options.preSavedGrid[9] + '||' + options.preSavedGrid['slider'][9] + ';';
		options.gridArray[10] = 10 + ':' + options.preSavedGrid[10] + '||' + options.preSavedGrid['slider'][10] + ';';
		options.gridArray[11] = 11 + ':' + options.preSavedGrid[11] + '||' + options.preSavedGrid['slider'][11] + ';';
		
		
		options.gridArray[0] = options.preSavedGrid['start'];
		
		
		
		options.gridArray[options.currentGridChangerIndex] = options.currentGridChangerIndex + ':' + options.gridStructures[options.currentGridChangerIndex][options.sliderValue] + '||' + options.sliderValue + ';';

		
		jQuery(options.preSavedGrid[options.currentGridChangerIndex]).remove();
		options.preSavedGrid[options.currentGridChangerIndex] = options.gridStructures[options.currentGridChangerIndex][options.sliderValue];
		
//		jQuery(options.preSavedGrid['slider'][options.currentGridChangerIndex]).remove();
		options.preSavedGrid['slider'][options.currentGridChangerIndex] = options.sliderValue;
		
		console.log(options.gridArray);
			
//			options.currentGridChangerIndex + ':' + options.grid[options.currentGridChangerIndex][options.sliderValue - 1] + '||' + options.sliderValue;
		
		
		return options.gridArray;
	}
	
	
	function gridChanger(options, obj) {
		
		// Define The UL Container For Changing Grids / Visualization
		var ulGridChangerContainer = obj.find('ul.grid-no');
		var ulGridLi = ulGridChangerContainer.find('li');
		var sliderContainer = obj.find('div#slider');
		var inputField = obj.find(':input');

		
		// Add The Class 'Current' To An Li
		var currentLi = ulGridLi.eq(options.preSavedGrid['start'] - 1).addClass('current').index();		
		
		// Define The Current Index And Increase It With 1 To Fit Our Grid Structure Array
		options.currentGridChangerIndex = currentLi + 1;
		
		// TODO Read The Last Active Setting Made
				// Lets Count The Different Grid Variants For A Specific Grid
				currentGridArrayLength = 0;
				for (i in options.gridStructures[options.currentGridChangerIndex]) {
				    if (options.gridStructures[options.currentGridChangerIndex].hasOwnProperty(i)) {
				    	currentGridArrayLength++;
				    }
				}
				
				options.sliderMax = currentGridArrayLength;
				sliderContainer.slider( "option", "max", options.sliderMax );
				
				options.sliderValue = options.preSavedGrid['slider'][options.currentGridChangerIndex];
				sliderContainer.slider( "option", "value", options.sliderValue );
				
		// Building Grid Visualization
		buildingGridVisualization(options, obj);
		
		// Lets Build The Slider
		buildSlider(options, obj);
		
		generateValueArray(options);

		
		options.sliderValue = options.preSavedGrid['slider'][options.currentGridChangerIndex];
		sliderContainer.slider( "option", "value", options.sliderValue );
		
		// Lets Define An Event If We Change The Grid Which We Want make Settings For.
		ulGridChangerContainer.find('li').on('click', function() {
			
			ulGridLi.removeClass('current');
			currentLi = jQuery(this).addClass('current').index();
			
			
			
			// Updates The Value Of For Start Index 
			options.preSavedGrid['start'] = currentLi + 1;
			inputField.val( generateValueArray(options) );
			
			
			options.currentGridChangerIndex = currentLi + 1;
			
			// Updates The Value Of Input Field
//			inputField.val( generateValueArray(options) );
//			generateValueArray(options);

			// Lets Count The Different Grid Variants For A Specific Grid
			currentGridArrayLength = 0;
			for (i in options.gridStructures[options.currentGridChangerIndex]) {
			    if (options.gridStructures[options.currentGridChangerIndex].hasOwnProperty(i)) {
			    	currentGridArrayLength++;
			    }
			}
			
			options.sliderMax = currentGridArrayLength;
			sliderContainer.slider( "option", "max", options.sliderMax );

				options.sliderValue = options.preSavedGrid['slider'][options.currentGridChangerIndex];
				sliderContainer.slider( "option", "value", options.sliderValue );
			
			console.log(options.sliderValue);
			
			// Building Grid Visualization
			buildingGridVisualization(options, obj);
			
			// Lets Build The Slider
			buildSlider(options, obj);
			
		});
	}
	
	
	
	/**
	 * Building Grid Visualization
	 * Creates some spans which shows the grid structure
	 */
	function buildingGridVisualization(options, obj, start) {
		
		// Define The Div Container Grid Display / Visualization
		var gridBlocksContainer = obj.find('div.grid-blocks');
		
		// Lets Remove All Children Before We Add New One
		gridBlocksContainer.children().empty().remove();
		
//		if(start) {
			
			generateValueArray(options)
			var alphabet = ['a','b','c','d','e','f','g','h','i','j','k','l'];
			jQuery.each(options.preSavedGrid[options.currentGridChangerIndex], function(i, val) {
				jQuery('<span class="grid-' + val + '">' + alphabet[i] + '</span>').appendTo(gridBlocksContainer);
			});
			console.log(options.preSavedGrid);
			
			// Reading The PreSaved Slider Value And Set It
			options.sliderValue = options.preSavedGrid['slider'][options.currentGridChangerIndex];
			
//			generateValueArray(options);
//		} else {
//			
//			// Append span tag to this div container
//			jQuery.each(options.gridStructures[options.currentGridChangerIndex][options.sliderValue], function(i, val) {
//				jQuery('<span class="grid-' + val + '">' + val + '</span>').appendTo(gridBlocksContainer);
//			});
//			
//			generateValueArray(options);
//		}
		
		console.log(obj);
	}
	
	
	
	// Definition Of Defaults
	jQuery.fn.moduleGrid.defaults = {
		gridStructures: '',
		grid: '',
		preSavedGrid: '',
		currentGridChangerIndex: 1,
		currentGridArrayLength: 1,
		gridArray: [],
		sliderValue:1,
		sliderMin: 1,
		sliderMax: 12,
		sliderStep: 1,
	};
	
})(jQuery);