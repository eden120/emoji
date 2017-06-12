package com.emojikeyboard.Api;

import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.GridView;

import com.emojikeyboard.Adapter.Gridview_image;
import com.emojikeyboard.BeanClass.GridData;
import com.emojikeyboard.BeanClass.GridValue;
import com.emojikeyboard.Download_image;
import com.emojikeyboard.Global.Global;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.HashMap;

/**
 * Created by Ajit on 9/22/2016.
 */
public class Get_category_Api_2 extends AsyncTask<String,Void,String> {

    private Context context;
    //private ProgressDialog dialog;
    private URL connectURL;
    private String responseaa;
    HttpURLConnection conn;
    int status,position;
    GridView gridView;
    String category_id,category_name,total;
    private JSONArray data1;
    private JSONObject category;
    DataOutputStream dos=null;
    GridValue gridvalue;
    private ArrayList<HashMap<String,String>> get_category_list;
    GridData gridData;
    GridValue gridValue;
    Download_image download_image;
    int pos;
    private ArrayList<String> data_code;

    public Get_category_Api_2(Context context,GridView gridView,int position,int pos)
    {
        this.context = context;
        this.gridView=gridView;
        this.position=position;
        this.pos=pos;
        gridData=new GridData();

        gridValue =  new GridValue();
        //dialog=new ProgressDialog(context);
        //*****************
        try
        {
            connectURL = new URL(Global.URL+"get_category.json");
        }
        catch (Exception ex)
        {
            Log.i("URL FORMATION", "MALFORMATED URL");
        }
    }


    @Override
    protected void onPreExecute() {
        gridData=new GridData();
        gridValue=new GridValue();

        get_category_list=new ArrayList<HashMap<String, String>>();

        data_code=new ArrayList<String>();

//        if(GridValue.data1.size()!=0 && position==1)
//        {
//
//            get_category_list.add(GridValue.data1);
//        }
//        if(GridValue.data2.size()!=0 && position== 2)
//        {
//            get_category_list.addAll(GridValue.data2);
//        }
//        if(GridValue.data3.size()!=0  && position==3)
//        {
//            get_category_list.addAll(GridValue.data3);
//        }
//        dialog.setMessage("Please Wait.....");
//        dialog.show();
    }


    @Override
    protected String doInBackground(String... params) {
        try{

            startPost();
            textpost("category_id", params[0]);
            textpost("page", params[1]);
            textpost("auth_key", "123");
            responseaa=endPost();
            Log.e("get_category", responseaa);
            HashMap<String,String> hash;
            JSONObject hh=new JSONObject(responseaa);
            status=   hh.getInt("status");
            category=hh.getJSONObject("category");
            category_name=category.getString("category_name");
            category_id=category.getString("category_id");
            data1=hh.getJSONArray("result");
            for(int i=0;i<data1.length();i++)
            {
                JSONObject c2 = data1.getJSONObject(i);
                hash=new HashMap<String, String>();
                hash.put("Iamge id",c2.getString("image_id"));
                hash.put("Image name",c2.getString("image"));
                get_category_list.add(hash);
            }
            total=hh.getString("totalpage");
            gridData.setTotal_page(total);
            //*******************
            if(status==1)
            {
                System.out.println("Hereeeeee");
                if( position==1)
                {
                    ArrayList<String> newdaa =new ArrayList<String>();
                    String data;
                    for(int i=0;i<get_category_list.size();i++)
                    {
                         data=get_category_list.get(i).get("Image name");
                        newdaa.add(data);
                    }
                    gridValue.setData1(newdaa);
                }

                if( position==2)
                {
                    ArrayList<String> newdaa =new ArrayList<String>();
                    String data;
                    for(int i=0;i<get_category_list.size();i++)
                    {
                        data=get_category_list.get(i).get("Image name");
                        newdaa.add(data);
                    }
                    gridValue.setData2(newdaa);
                }

                if( position==3)
                {
                    ArrayList<String> newdaa =new ArrayList<String>();
                    String data;
                    for(int i=0;i<get_category_list.size();i++)
                    {
                        data=get_category_list.get(i).get("Image name");
                        newdaa.add(data);
                    }
                    gridValue.setData3(newdaa);
                }
                System.out.println("success");
            }
            else{
                System.out.println("failure");
            }
        }
        catch (Exception e)
        {
            System.out.println(e);
        }
        return null;
    }

    @Override
    protected void onPostExecute(String s) {
//        if (dialog.isShowing()) {
//            dialog.dismiss();}

        if(position==1)
        {
            gridData.setGet_category(get_category_list);
            download_image=new Download_image(context,get_category_list,category_name,position);
            gridView.setAdapter(new Gridview_image(context,GridValue.data1,category_name,position));
            System.out.println("System1");
        }
        else if(position==2)
        {
            gridData.setGet_category(get_category_list);
            System.out.println("final value2"+GridValue.data2);
            download_image=new Download_image(context,get_category_list,category_name,position);
            gridView.setAdapter(new Gridview_image(context,GridValue.data2,category_name,position));
            System.out.println("System2");
        }
        else{
            gridData.setGet_category(get_category_list);
            System.out.println("final value3"+GridValue.data3);
            download_image=new Download_image(context,get_category_list,category_name,position);
            gridView.setAdapter(new Gridview_image(context,GridValue.data3,category_name,position));
            System.out.println("System3");
        }

    }
    private void startPost(){

        try {
            conn = (HttpURLConnection) connectURL.openConnection();
            conn.setDoInput(true);
            conn.setDoOutput(true);
            conn.setUseCaches(false);
            conn.setRequestMethod("POST");
            conn.setRequestProperty("Connection", "Keep-Alive");
            conn.setRequestProperty("Content-Type","multipart/form-data;boundary=" + "*****");
            dos = new DataOutputStream(conn.getOutputStream());
            dos.writeBytes("--*****\r\n");
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    private void textpost(String key,String value){
        try {
            dos.writeBytes("Content-Disposition: form-data; name=\""+key+"\"\r\n");
            dos.writeBytes("Content-Type: text/plain;charset=UTF-8\r\n");
            dos.writeBytes("\r\n");
            dos.writeBytes(value + "\r\n");
            dos.writeBytes("--*****\r\n");
        } catch (IOException e) {
            e.printStackTrace();
        }

    }
    private String endPost(){
        String responce="";
        InputStream is;
        try {
            is = conn.getInputStream();
            int ch;
            StringBuffer b = new StringBuffer();
            while ((ch = is.read()) != -1) {
                b.append((char) ch);
            }
            responce = b.toString();
            dos.close();
            dos.flush();
        } catch (IOException e) {
            e.printStackTrace();
        }
        return responce;
    }
public ArrayList<String> hell()
{
    ArrayList<String> hel=new ArrayList<String>();

    return hel;
}

}

