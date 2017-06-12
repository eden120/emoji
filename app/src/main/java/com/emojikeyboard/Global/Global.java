package com.emojikeyboard.Global;

import android.graphics.Bitmap;

import java.util.ArrayList;
import java.util.HashMap;

/**
 * Created by Ajit on 8/30/2016.
 */
public class Global {
    public static String URL="http://testondev.com/cdg/emoji_app/api/";
//    public static  String URL="http://192.168.0.127/emoji_app/api/";
    public static ArrayList<String> image = new ArrayList<String>();

    public  ArrayList<String> getImage() {
        return image;
    }

    public  void setImage(ArrayList<String> image) {
        Global.image = image;
    }
}
