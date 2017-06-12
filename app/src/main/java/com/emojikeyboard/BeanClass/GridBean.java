package com.emojikeyboard.BeanClass;

import android.graphics.Bitmap;

import java.util.ArrayList;

/**
 * Created by Ajit on 8/25/2016.
 */
public class GridBean {
    public static ArrayList<String> image = new ArrayList<String>();

    public ArrayList<String> getImage() {
        return image;
    }

    public void setImage(ArrayList<String> image) {
        this.image = image;
    }

    public static String value1,value2;

    public String getValue1() {
        return value1;
    }

    public void setValue1(String value1) {
        this.value1 = value1;
    }

    public String getValue2() {
        return value2;
    }

    public void setValue2(String value2) {
        this.value2 = value2;
    }
}
