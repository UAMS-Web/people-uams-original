
	jQuery(document).ready(function($){
		// make sure acf is loaded, it should be, but just in case
		if (typeof acf == 'undefined') { return; }

		// extend the acf.ajax object
		// you should probably rename this var
		var pubmedExtension = acf.ajax.extend({
			events: {
				// this data-key must match the field key for the input field that
				// will trigger the change of the other fields. In this case, the input field
				// is a text field and we need to set an event and get the value.
				// When ACF updates the value it triggers a change action on a different t
				// extarea field than the one that will contain the value
				'change [data-key="field_5922e40db4057"] .acf-input input': '_text_change',
			},

			_text_change: function(e) {

				// get which input changed
				var $input = e.$el;
				// create the target id
				var $target = $input.attr('id').replace('field_5922e40db4057', 'field_592437c881851');

				//console.log($input);
				//console.log('textarea#' +$target);

				// clear existing values from the fields we will update
				// clear input field
				// targer == field key of textarea field
				$( 'textarea#' +$target ).val('');

				// get the input value
				var $value = e.$el.val();

				// if there is no value, exit
				if (!$value) {
					return;
				}

				//console.log('started ' + $value);

				// now we can do our ajax request

				// I assume this tests to see if there is already a request
				// for this and cancels it if there is
				if( this.request) {
					this.request.abort();
				}

				// I don't know exactly what it does
				// acf does it so I copied it
				var self = this,
				    data = this.o;

				// set the ajax action that's set up in php
				data.action = 'load_content_from_pubmed';
				// set the term id value to be submitted
				data.pmid = $value;

				// this is another bit I'm not sure about
				// copied from ACF
				data.exists = [];

				// this the request is copied from ACF
				this.request = $.ajax({
					url:		acf.get('ajaxurl'),
					data:		acf.prepare_for_ajax(data),
					type:		'post',
					dataType:	'json',
					async: true,
					success: function(json){

						if (!json) {
							return;
						}

						console.log('ajax success');

						//console.log(json);

						// put the values into the fields
						if (json['full']) {
							// data-key == field key of textarea field
							// originally '[data-key="field_592437c881851"] textarea'
							$( 'textarea#' +$target ).val(json['full']);
						}
					},
					error: function(jqXHR, textStatus, error) {
						alert (jqXHR+' : '+textStatus+' : '+error);
					}
				});
			},
		});

	});
