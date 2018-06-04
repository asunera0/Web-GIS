//CREATE TABLE nycgrid (id character(32), the_geometry Geometry);

import java.io.*;
import java.util.*;
import java.util.Scanner;
import java.io.FileNotFoundException;

public class GenInsertCrash
{
   public static void main (String args[]) throws FileNotFoundException
  {
	File file = new File("schools.csv");
	Scanner scan = new Scanner(file);
    	while(scan.hasNext()){
        	String[] tokens = scan.nextLine().split(",");
		String lat = tokens[0];
		String lng = tokens[1];
		String geomType = tokens[2];
		String district = tokens[3];
		String dbn=  tokens[4];
		String name = tokens[5];
		String totalStudents= tokens[6];
		String gradRate= tokens[7];
                String safety = tokens[8];
		String quality = tokens[9];
		String classSize = tokens[10];
		String ELL = tokens[11];
		String IEP = tokens[12];
                String freeLunch = tokens[13];
                String asian = tokens[14];
                String black = tokens[15];
                String hispanic = tokens[16];
                String white = tokens[17];
                String x = tokens[18];
                String y = tokens[19];
		String coors=x+" "+y;

		String sqlstr= "insert into schools values ('"+lat+"','"+lng+"','"+geomType+"','"+district+"','"+dbn+"','"+name+"', '"+totalStudents+"', '"+gradRate+"','"+safety+"','"+quality+"','"+classSize+"','"+ELL+"','"+IEP+"','"+freeLunch+"','"+asian+"','"+black+"','"+hispanic+"','"+white+"',st_geomFromText('POINT("+coors+")',2263));";

		System.out.println(sqlstr);
	}
  }
}

