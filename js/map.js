var width = screen.width/2,
height = 500;

var svg = d3.select("#blr_map").attr("height", height);

var xym = d3.geo.albers();
var path = d3.geo.path().projection(xym);

xym.origin([77.68, 12.67])
xym.translate([350, 745])
xym.parallels([24.6, 43.6])
xym.scale(90000)

if(screen.width < 600){
  xym.scale(62000)
  xym.origin([77.78, 12.5])
}
          

d3.json("Bangalore.GeoJSON", function(data) {

  svg.selectAll("path")
    .data(data.features)
    .enter()
    .append("path")
    .attr("d", path)
    //.attr("fill", "none")
    .attr("stroke", "White")
    .attr("fill", "#157fda")
    .attr("stroke-width", 1)
    .attr("stroke-opacity", 0.5)
    .attr("class", "place")
    .style("fill", function(e) { 

    let c;

    if(stats[parseInt(e.properties.WARD_NO)] != undefined){
      c = stats[parseInt(e.properties.WARD_NO)].cases;
    }
    else{
      c = '3-10';
    }

    //let c = stats[parseInt(e.properties.WARD_NO)].cases;

    if(c == '0'){ 
      console.log('0: '+e.properties.WARD_NAME);
      return "rgba(21, 127, 218, 0.1)";
    }
    else if(c == '1-2'){
      console.log('1-2: '+e.properties.WARD_NAME);
      return "rgba(21, 127, 218, 0.2)";
    }
    else if(c == '3-10'){
      console.log('3-10: '+e.properties.WARD_NAME);
      return "rgba(21, 127, 218, 0.3)";
    }
    else if(parseInt(c) >= 10 && parseInt(c) <= 15){
      return "rgba(21, 127, 218, 0.5)";
    }
    else if(c == '10-15'){
      console.log('10-15: '+e.properties.WARD_NAME);
      return "rgba(21, 127, 218, 0.5)";
    }
    else if(parseInt(c) > 15 && parseInt(c) < 50){
      console.log('15-50: '+e.properties.WARD_NAME);
      return "rgba(21, 127, 218, 0.7)";
    }
    else if(c >= 50){
      console.log('>50: '+e.properties.WARD_NAME);
      return "rgba(21, 127, 218, 1)";
    }
})
.on("mouseover", function(e) {
  /*console.log(e);*/ 
  d3.select(this).style("fill", "#5522aa");

  $("#map_ward").html(e.properties.WARD_NAME);
  $("#map_cases").html(stats[parseInt(e.properties.WARD_NO)] ? stats[parseInt(e.properties.WARD_NO)].cases + ' cases' : '3-10 cases');
})
.on("mouseout", function(e) {
  let c;
  let color;

  if(stats[parseInt(e.properties.WARD_NO)] != undefined){
      c = stats[parseInt(e.properties.WARD_NO)].cases;
  }
  else{
      c = '3-10';
  }

  if(c == '0'){ 
      color = "rgba(21, 127, 218, 0.1)";
  }
  else if(c == '1-2'){
      color = "rgba(21, 127, 218, 0.2)";
  }
  else if(c == '3-10'){
      color = "rgba(21, 127, 218, 0.3)";
  }
  else if(parseInt(c) >= 10 && parseInt(c) <= 15){
      color = "rgba(21, 127, 218, 0.5)";
  }
  else if(c == '10-15'){
      color = "rgba(21, 127, 218, 0.5)";
  }
  else if(c > 15 && c < 50){
       color = "rgba(21, 127, 218, 0.7)";
  }
                  else{
      color = "rgba(21, 127, 218, 1)";
  }

  d3.select(this).style("fill", color);})

var svg1 = d3.select("#legends");

  // Handmade legend
  svg1.append("circle").attr("cx",10).attr("cy",30).attr("r", 6).style("fill", "rgba(21, 127, 218, 0.1)")
  svg1.append("circle").attr("cx",10).attr("cy",60).attr("r", 6).style("fill", "rgba(21, 127, 218, 0.2)")
  svg1.append("circle").attr("cx",100).attr("cy",30).attr("r", 6).style("fill", "rgba(21, 127, 218, 0.3)")
  svg1.append("circle").attr("cx",100).attr("cy",60).attr("r", 6).style("fill", "rgba(21, 127, 218, 0.5)")
  svg1.append("circle").attr("cx",210).attr("cy",30).attr("r", 6).style("fill", "rgba(21, 127, 218, 0.7)")
  svg1.append("circle").attr("cx",210).attr("cy",60).attr("r", 6).style("fill", "rgba(21, 127, 218, 1)")
  svg1.append("text").attr("x", 20).attr("y", 30).text("No cases").style("font-size", "12px").attr("alignment-baseline","middle")
  svg1.append("text").attr("x", 20).attr("y", 60).text("1 - 2 cases").style("font-size", "12px").attr("alignment-baseline","middle")
  svg1.append("text").attr("x", 110).attr("y", 30).text("3 - 10 cases").style("font-size", "12px").attr("alignment-baseline","middle")
  svg1.append("text").attr("x", 110).attr("y", 60).text("10 - 15 cases").style("font-size", "12px").attr("alignment-baseline","middle")
  svg1.append("text").attr("x", 220).attr("y", 30).text("15 - 50 cases").style("font-size", "12px").attr("alignment-baseline","middle")
  svg1.append("text").attr("x", 220).attr("y", 60).text("more than 50 cases").style("font-size", "12px").attr("alignment-baseline","middle")

})

