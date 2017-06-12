package com.emojikeyboard.Api;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;
import android.view.View;

import com.emojikeyboard.BeanClass.GridData;
import com.emojikeyboard.CandidateView1;
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
 * Created by Ajit on 9/8/2016.
 */
public class Get_category_Api extends AsyncTask<String,Void,String> {

    private Context context;
    //private ProgressDialog dialog;
    private URL connectURL;
    private String responseaa;
    HttpURLConnection conn;
    int status;
    String category_id,category_name,total;
    private JSONArray data1;
    private JSONObject category;
    DataOutputStream dos=null;
    private ArrayList<HashMap<String,String>> get_category_list;
    GridData gridData;

    public Get_category_Api(Context context)
    {
        this.context = context;

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
        get_category_list=new ArrayList<HashMap<String, String>>();
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
            gridData.setName(category_name);
            System.out.println("cat_name"+category_name);
            total=hh.getString("totalpage");
            gridData.setTotal_page(total);
            //*******************
            if(status==1)
            {

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
}
