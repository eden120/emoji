package com.emojikeyboard.BeanClass;

import java.util.ArrayList;

/**
 * Created by Ajit on 9/24/2016.
 */
public class CheckBean {
    public static ArrayList<String> name;
    public static ArrayList<String> path;

    public ArrayList<String> getPath() {
        return path;
    }

    public void setPath(ArrayList<String> path) {
        this.path = path;
    }

    public  ArrayList<String> getName() {
        return name;
    }

    public  void setName(ArrayList<String> name) {
        CheckBean.name = name;
    }
}
