
var active_screen = "screen1";
var screenshots_id_list = ["screen1", "screen2", "screen3"];
var pointers_id_list = ["pointer1", "pointer2", "pointer3"];
var z_index_values_list = ["1000", "500", "250"];
var brigthnes_value_list = ["brightness(100%)","brightness(80%)","brightness(50%)"]
var pointers_value_list = ["15px", "10px", "10px"];




function change_app_screenshot(screen_id){

   if(active_screen != "screen1" && active_screen==screen_id){
      active_screen = "screen1";

      //return default screenchots order

      var i;
      for(i=0; i<screenshots_id_list.length; i++){
         $("#"+screenshots_id_list[i]).css("z-index", z_index_values_list[i]);
         $("#"+screenshots_id_list[i]).css("filter", brigthnes_value_list[i]);

         $("#"+pointers_id_list[i]).css("width", pointers_value_list[i]);
         $("#"+pointers_id_list[i]).css("height", pointers_value_list[i]);
      }
   }
   else{

      var i;
      var t=1;

      for(i=0; i<screenshots_id_list.length; i++){

         if(screen_id == screenshots_id_list[i]){
            active_screen = screen_id;
            $("#"+screen_id).css("z-index", "1000");
            $("#"+screen_id).css("filter", "brightness(100%)");

            $("#"+pointers_id_list[i]).css("width", "15px");
            $("#"+pointers_id_list[i]).css("height", "15px");
         }
         else{
            $("#"+screenshots_id_list[i]).css("z-index", z_index_values_list[t]);
            $("#"+screenshots_id_list[i]).css("filter", brigthnes_value_list[t]);

            $("#"+pointers_id_list[i]).css("width", "10px");
            $("#"+pointers_id_list[i]).css("height", "10px");
            t++;

         }
      }
   }
}
