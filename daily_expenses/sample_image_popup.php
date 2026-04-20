<?php
$image_name=$_GET['sample_image'];
?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />
<script type="text/javascript" src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="../customer_creation/js/imgViewer2.js"></script>

<center><img src="../../kun_tyres/fab_sup_upload_file/<?php echo $image_name;?>" name="image_name" width="90%" height="100%" id="image1"/></center>

<script type="text/javascript">
;(function($) {

	$.widget("wgm.imgNotes2", $.wgm.imgViewer2, {
		options: {

			addNote: function(data) {
				var map = this.map,
					loc = this.relposToLatLng(data.x, data.y);
				var marker = L.marker(loc).addTo(map).bindPopup(data.note+"</br><input type='button' value='Delete' class='marker-delete-button'/>");
				marker.on("popupopen", function() {
					var temp = this;
					$(".marker-delete-button:visible").click(function () {
						temp.remove();
					});
				});
			}
		},
		
				import: function(notes) {
			if (this.ready) {
				var self = this;
				$.each(notes, function() {
					self.options.addNote.call(self, this);
				});	
			}
		}
	});
	$(document).ready( function() {
		var $img = $("#image1").imgNotes2({
						onReady: function() {
							var notes = [];
							this.import(notes);
						}
					});
	});
})(jQuery);
</script>