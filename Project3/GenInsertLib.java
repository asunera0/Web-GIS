//CREATE TABLE nycgrid (id character(32), the_geometry Geometry);

import java.io.*;
import java.util.*;
import java.util.Scanner;
import java.io.FileNotFoundException;

public class GenInsertLib
{
   public static void main (String args[]) throws FileNotFoundException
  {
	File file = new File("libs.csv");
	Scanner scan = new Scanner(file);
    	while(scan.hasNext()){
        	String[] tokens = scan.nextLine().split(",");
		String lat = tokens[0];
		String lng = tokens[1];
		String altitude = tokens[2];
		String geomType = tokens[3];
		String x=  tokens[4];
		String city = tokens[5];
		String name= tokens[6];
		String system= tokens[7];
                String zip = tokens[8];
		String url = tokens[9];
		String y = tokens[10];
		String bbl = tokens[11];
		String streetname = tokens[12];
                String housenum = tokens[13];
                String borocd = tokens[14];
                String bin = tokens[15];
		String coors=x+" "+y;

		String sqlstr= "insert into libraries values ('"+lat+"','"+lng+"','"+geomType+"','"+city+"','"+name+"','"+system+"', '"+zip+"', '"+url+"','"+x+"','"+y+"','"+streetname+"','"+housenum+"','"+borocd+"','"+bin+"',st_geomFromText('POINT("+coors+")',2263));";

		System.out.println(sqlstr);
	}
  }
}

