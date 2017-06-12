package com.emojikeyboard;

import android.app.DownloadManager;
import android.content.Context;
import android.net.Uri;
import android.os.Environment;

import com.emojikeyboard.BeanClass.CheckBean;
import com.emojikeyboard.BeanClass.Copy_image_bean;
import com.emojikeyboard.BeanClass.GridData;

import java.io.File;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;
import java.util.Comparator;
import java.util.HashMap;

/**
 * Created by Ajit on 9/23/2016.
 */
public class Download_image {
    String data[];
    int i;
    GridData gridData;
    String name="";
    ArrayList<HashMap<String,String>> image;
    String name1,filename1;
    Context context;
    File direct;
    File allFiles[];
    int position;
    private ArrayList<String> bitmaapArray_name;
    private ArrayList<String> bitmaapArray_path;
    CheckBean checkBean;
    public Download_image(Context context,ArrayList<HashMap<String,String>> image,String name1,int position)
    {
        gridData=new GridData();
        this.name1=name1;
        this.image=image;
        this.position=position;
        this.context=context;
        hello();
    }

    public void hello()
    {
        for( i=0;i<image.size();i++)
        {
            downloadFile(image.get(i).get("Image name"));
        }
    }
    public void downloadFile(String url) {
        checkBean=new CheckBean();
        String filename;
         direct = new File(Environment.getExternalStorageDirectory()
                + "/EmojiKeyboards" + "/"+name1);

        if (!direct.exists()) {
            direct.mkdirs();
        }

        File[] listFiles = direct.listFiles();
        if(listFiles.length!=0 && i<listFiles.length)
        {
            filename= String.valueOf(sortByNumber(listFiles));
             filename1=filename.substring(name.lastIndexOf("/")+1);
            data=filename1.split(".png");
            String s=sa(data);
        }
//        System.out.println("sa(data)"+sa(data));




        if(listFiles.length!=0&&listFiles.length<image.size())
        {
            check();
            String id=gridData.getGet_category().get(i).get("Iamge id");
            id=id+".png";
//            System.out.println(id+checkBean.getName().get(i));


            try {
                if(id.equals(checkBean.getName().get(i)))
                {
                    System.out.println("assssssssss"+checkBean.getPath().get(i));
                }
            }
            catch (Exception e)
            {
                System.out.println(e);
                String name=image.get(i).get("Image name");
                System.out.println("name"+name);
                DownloadManager mgr = (DownloadManager) context.getSystemService(Context.DOWNLOAD_SERVICE);
                Uri downloadUri = Uri.parse(name);
                DownloadManager.Request request = new DownloadManager.Request(
                        downloadUri);
                request.setAllowedNetworkTypes(DownloadManager.Request.NETWORK_WIFI | DownloadManager.Request.NETWORK_MOBILE)
                        .setAllowedOverRoaming(false).setTitle("Download Image")
                        .setDescription("Something useful. No, really.");
                request.setDestinationInExternalPublicDir("/EmojiKeyboards" + "/" + name1, gridData.getGet_category().get(i).get("Iamge id") + ".png");
                mgr.enqueue(request);
            }


}


        if (listFiles.length==0) {
//        if (listFiles.length==0||listFiles.length>image.size()||!sa(data).equals(gridData.getGet_category().get(i).get("Iamge id"))) {
            String id=image.get(i).get("Iamge id");
            id=id+".png";

                System.out.println("askaas");

                DownloadManager mgr = (DownloadManager) context.getSystemService(Context.DOWNLOAD_SERVICE);
                Uri downloadUri = Uri.parse(url);
                DownloadManager.Request request = new DownloadManager.Request(
                        downloadUri);
                request.setAllowedNetworkTypes(DownloadManager.Request.NETWORK_WIFI | DownloadManager.Request.NETWORK_MOBILE)
                        .setAllowedOverRoaming(false).setTitle("Download Image")
                        .setDescription("Something useful. No, really.");
                request.setDestinationInExternalPublicDir("/EmojiKeyboards" + "/" + name1, gridData.getGet_category().get(i).get("Iamge id") + ".png");
                mgr.enqueue(request);

        } else if(sa(data).equals(gridData.getGet_category().get(i).get("Iamge id"))) {
            System.out.println("file content already exits");
        }
    }
    public String sa(String hell[])
    {
        StringBuilder builder = new StringBuilder();
        for(String s : data) {
            builder.append(s);
        }
        return builder.toString();
    }
    public String sortByNumber(File[] files) {
        String value1;
        ArrayList<String> arrayList=new ArrayList<String>();
        Arrays.sort(files, new Comparator<File>() {
            @Override
            public int compare(File o1, File o2) {
                int n1 = extractNumber(o1.getName());
                int n2 = extractNumber(o2.getName());
                return n1 - n2;
            }
            private int extractNumber(String name) {
                int i = 0;
                try {
                    int s = name.indexOf('_')+1;
                    int e = name.lastIndexOf('.');
                    String number = name.substring(s, e);
                    i = Integer.parseInt(number);
                } catch(Exception e) {
                    i = 0; // if filename does not match the format
                    // then default to 0
                }
                return i;
            }
        });
        for(File f : files) {
            value1 = f.getName();
            arrayList.add(value1);
        }
        return arrayList.get(i);
    }

    public void check() {

        bitmaapArray_name=new ArrayList<String>();
        bitmaapArray_path=new ArrayList<String>();
        if (direct.isDirectory()) {
            allFiles = direct.listFiles();
            for (int i = 0; i < allFiles.length; i++) {
                String s = allFiles[i].getAbsolutePath();
                String s1 = allFiles[i].getName();
                bitmaapArray_path.add(s);
                bitmaapArray_name.add(s1);
                Collections.sort(bitmaapArray_name);
                Collections.sort(bitmaapArray_path);
                checkBean.setPath(bitmaapArray_path);
                checkBean.setName(bitmaapArray_name);
            }
        }
    }
}
