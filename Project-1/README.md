#Project - 1 


Task 0 :
1. Created a folder proj1 in /public_html then downloaded the .sql files of five datasets AOI,hw,cd cg,sd which consists of NYC geospatial data using command:
wget http://geoteci.engr.ccny.cuny.edu/WebGIS/proj1_data.tar 
1. Unzipped the downloaded folder of geospatial data consisting of five datasets 
Command : tar -xvf  proj1_data.tar
1. Populated the database using following command :
       /usr/local/pgsql/bin/psql -h 0.0.0.0 -d dbname -U username  -f aoi.sql
Similarly for hw,cd,cg and sd  I have used the above database commands.
Task 1 :
I have used static map configuration to specify layers in .map file.To visualize these  layers on web browser I retrieved data using below queries
1. Querying all aoi tuples.
select * from aoi;
1. Querying highway routes (identified by georte) that consist of two or more segments (identified by route)
select * from hw where georte in select georte as georte from hw group by georte having count(*)>=2);
1. Querying community districts in Queens (borocd begin with 4).
select * from cd where (borocd/100)=4;
1.  Computing the convex hull of the aoi table 
select  row_number() over () as id, ST_ConvexHull(ST_Collect(the_geom)) As the_geom from aoi;
1.  Generating buffers for the tuples in the hw table using a radius of 5000 feet
select gid,st_buffer(the_geom,5000) as the_geom from hw;
1. Deriving the intersection, union, A-B, B-A and symmetrical differences of  the tuples in cg and in sd that contain an aoi tuple whose id is 79 
select 1 as id,st_intersection(cg_79.the_geom,sd_79.the_geom) as the_geom from cg_79,sd_79;
cg_79 and sd_79 are the temporary table I have created which contains cg and sd having aoi tuple with id 79
* select id,cg.the_geom 
into cg_79
from cg,aoi 
where aoi.id=79 and st_intersects(cg.the_geom,aoi.the_geom)
* select id,sd.the_geom 
into sd_79
from sd,aoi 
where aoi.id=79 and st_intersects(sd.the_geom,aoi.the_geom)




Task 3 :


1. Downloaded the project skeleton using following command in proj1 folder
wget link-WebGIS/proj1
1.   Unzipped the downloaded folder into same folder using
   tar -zxvf  proj1_template.tar.gz


             
1. Proj1  folder consists of three folders maps,mapscripts,js and template.html file
2. Created 3 .html files and named them as
 template1.html : This file consists of initialization and declaration of three layers AOI,Community district and Highway routes.
Initialized three layers as : var l_aoi,l_comdis,l_hw; 
Created layers as : 
*    l_aoi = new OpenLayers.Layer.WMS("NYC AOI","http://134.74.146.40/~su/proj1/mapscripts/template1.php?", {layers:'aoi',format: "image/png"}) ;
* l_comdis = new OpenLayers.Layer.WMS("Communtiy District Queens","http://134.74.146.40/~su/proj1/mapscripts/template1.php?", {layers:'cd1',format: "image/png"} );
*  l_hw = new OpenLayers.Layer.WMS("Highway Routes","http://134.74.146.40/~su/proj1/mapscripts/template1.php?", {layers:'hw',format: "image/png"} );


 Invoking the layers using map.addLayer() as :  
map.addLayer(l_aoi);
             map.addLayer(l_comdis);
             map.addLayer(l_hw);
template2.html :  This file consists of initialization and declaration of two layers Convex Hull of AOI,Highway Buffers..
Initialized three layers as : var l_aoich,l_hwbuf; 
Created layers as :
*  l_aoich = new OpenLayers.Layer.WMS("Convex Hull AOI","http://134.74.146.40/~su/proj1/mapscripts/template2.php?", {layers:'ConHullAOI',format: "image/png"} );
      
*  l_hwbuf = new OpenLayers.Layer.WMS("Highway Buffers","http://134.74.146.40/~su/proj1/mapscripts/template2.php?", {layers:'HWBuff',format: "image/png"} );
      
 Invoking the layers using map.addLayer() as :  
map.addLayer(l_aoich);
             map.addLayer(l_hwbuf);
template3.html :   This file consists of initialization and declaration of five layers 
Initialized three layers as : var l_ab,l_ba,l_in,l_un,l_symd;
Created layers as :
* l_in = new OpenLayers.Layer.WMS("Intersection","http://134.74.146.40/~su/proj1/mapscripts/template.php?", {layers:'in',format: "image/png"} );
        
* l_un = new OpenLayers.Layer.WMS("Union","http://134.74.146.40/~su/proj1/mapscripts/template.php?", {layers:'un',format: "image/png"} );
          
* l_ab = new OpenLayers.Layer.WMS("Difference CG-SD","http://134.74.146.40/~su/proj1/mapscripts/template.php?", {layers:'ab',format: "image/png"} );
          
* l_ba = new OpenLayers.Layer.WMS("Difference SD-CG ","http://134.74.146.40/~su/proj1/mapscripts/template.php?", {layers:'ba',format: "image/png"} );
     
* l_symd = new OpenLayers.Layer.WMS("Sym Diff ","http://134.74.146.40/~su/proj1/mapscripts/template.php?", {layers:'symd',format: "image/png"} );
         
 Invoking the layers using map.addLayer() as :  
    map.addLayer(l_in);
    map.addLayer(l_un);
    map.addLayer(l_ab);
    map.addLayer(l_ba);
    map.addLayer(l_symd);


        3. Created 3 .php file under /public_html/proj1/mapscripts and named the as 
template1.php,template2.php,template3.php : These files consists of map object .
Created a new map object and provided path of the .map file
as following in each file :
$oMap = ms_newMapobj("/home/sune17/public_html/proj1/maps/template.map");
This file provides the definition of map file. 


1. Created a .map file under /public_html/proj1/maps
as template.map : This mapfile consists of all layers and symbol definition
I have created symbol definition for 
POINT :    SYMBOL
      NAME 'circle'
      TYPE ELLIPSE
      POINTS 1 1 END
      FILLED TRUE
      END
LINE :   SYMBOL
  NAME 'circlef '
  TYPE ELLIPSE
  POINTS 1 1
  END
  FILLED TRUE
  END
Defining LAYERS in map file as 
For each layer :
*  Specify connection type as :
CONNECTIONTYPE POSTGIS
*  To connect to database we define database connection in CONNECTION parameter
  CONNECTION  "user=uname password=pwd dbname=dbname host=0.0.0.0"
*  Providing database  query in DATA element for each layer to draw the results on map   
* In PostGIS layer to every query we specify a unique id to create a VIEW if we want make query calls.
*  SRID is a coordinate where we store our data.Using SRID we store data in a single coordinate system of a projected coordinate which provides the local interpretation of data in the units. In this case it is 2263.
* Map file consists of PROJECTION having epsg:2263 epsg is geodetic parameter dataset lookup file containing projection parameters, map file has zero or more OUTPUTFORMAT. In my map file OUTPUTFORMAT has  name png ,driver as GD/PNG ,driver name is used to generate output format and MIMETYPE image/png.It may also have other formats like png,gif,jpeg.
