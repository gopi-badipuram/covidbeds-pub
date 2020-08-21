$(document).ready(function() {

            let vid_htm = ``;

            if(screen.width <= 600){
               vid_htm = `<center><iframe src="https://www.youtube.com/embed/zvE7iuQI8Yc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></center>`;
            }
            else{
               vid_htm = `<center><iframe width="640" height="390" src="https://www.youtube.com/embed/zvE7iuQI8Yc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></center>`;
            }
            $("#vid_div").html(vid_htm);
});
