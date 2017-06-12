package com.emojikeyboard.BeanClass;

import java.util.ArrayList;
import java.util.HashMap;

/**
 * Created by Ajit on 9/6/2016.
 */
public class GridData {
    public static ArrayList<String> value = new ArrayList<String>();

    public ArrayList<String> getValue() {
        return value;
    }

    public void setValue(ArrayList<String> value) {
        GridData.value = value;
    }




    public static ArrayList<HashMap<String,String> >datavalue=new ArrayList<HashMap<String,String>>();

    public ArrayList<HashMap<String, String>> getDatavalue() {
        return datavalue;
    }

    public void setDatavalue(ArrayList<HashMap<String, String>> datavalue) {
        this.datavalue = datavalue;
    }




    public static  ArrayList<String> all_category_list=new ArrayList<String>();

    public ArrayList<String> getAll_category_list() {
        return all_category_list;
    }

    public void setAll_category_list(ArrayList<String> all_category_list) {
        this.all_category_list = all_category_list;
    }


    public static ArrayList<HashMap<String,String>> get_category=new ArrayList<HashMap<String, String>>();

    public ArrayList<HashMap<String, String>> getGet_category() {
        return get_category;
    }

    public void setGet_category(ArrayList<HashMap<String, String>> get_category) {
        this.get_category = get_category;
    }



    public static String name;

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }



    public static String total_page;

    public String getTotal_page() {
        return total_page;
    }

    public void setTotal_page(String total_page) {
        this.total_page = total_page;
    }
}
