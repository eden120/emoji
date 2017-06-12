package com.emojikeyboard;

import android.os.Environment;

import com.emojikeyboard.BeanClass.Copy_image_bean;
import com.emojikeyboard.BeanClass.GridBean1;

import java.io.File;
import java.util.ArrayList;

/**
 * Created by Ajit on 9/24/2016.
 */
public class Copy_image {
    private File[] allFiles;
    Copy_image_bean copy_image_bean;
    private ArrayList<String> value;

    public void griddata(String data,int position) {
        value=new ArrayList<String>();
        copy_image_bean=new Copy_image_bean();
        File folder = new File(Environment.getExternalStorageDirectory().getPath() + "/EmojiKeyboards" + "/" + data);
        if (folder.isDirectory()) {
            allFiles = folder.listFiles();
            for (int i = 0; i < allFiles.length; i++) {
                String s = allFiles[i].getAbsolutePath();

                value.add(s);

                if(position==1)
                {
                   copy_image_bean.setValue1(value);
                }
                else if(position==2)
                {
                    copy_image_bean.setValue2(value);
                }
                else
                {
                    copy_image_bean.setValue3(value);
                }
            }
        }
    }
}
