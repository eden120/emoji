package com.emojikeyboard.Api;

import android.app.Activity;
import android.app.DownloadManager;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Environment;
import android.util.Log;
import android.widget.ListView;

import com.emojikeyboard.BeanClass.GridData;
import com.emojikeyboard.Global.Global;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import java.io.DataOutputStream;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.lang.reflect.Array;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Comparator;
import java.util.HashMap;

/**
 * Created by Ajit on 8/11/2016.
 */
public class All_Categories_Api extends AsyncTask<String,Void, String> {
    public ArrayList<HashMap<String,String>> all_category_list;
    HttpURLConnection conn;
    private URL connectURL;
    private String responseaa;
    Context c;
    JSONArray data1;
    int status;
    GridData gridData;
    private ProgressDialog dialog;
    DataOutputStream dos=null;
    int i ,j;
    String name="";
    String data[];
   //*****************

    public All_Categories_Api(Context mContext)
    {
        this.c = mContext;

       // dialog=new ProgressDialog(c);
        //*****************
        try
        {
            connectURL = new URL(Global.URL+"all_categories.json");
        }
        catch (Exception ex)
        {
            Log.i("URL FORMATION", "MALFORMATED URL");
        }
    }

    @Override
    protected void onPreExecute() {
        all_category_list=new ArrayList<HashMap<String, String>>();
        gridData=new GridData();
/*        dialog.setMessage("Please Wait.....");
        dialog.show();*/

    }
    @Override
    protected String doInBackground(String... params) {
        try {
            startPost();
            textpost("auth_key", "123");
            responseaa=endPost();
            Log.e("all_categories", responseaa);
            HashMap<String,String> hash;
            JSONObject hh=new JSONObject(responseaa);
            status=   hh.getInt("status");
            data1=hh.getJSONArray("result");
            for(int i=0;i<data1.length();i++)
            {
                JSONObject c2 = data1.getJSONObject(i);
                hash=new HashMap<String, String>();
                hash.put("Category id",c2.getString("category_id"));
                hash.put("Category name",c2.getString("category_name"));
                hash.put("Category image",c2.getString("category_image"));
                all_category_list.add(hash);
            }

            //*******************

            if(status==1){
                gridData.setDatavalue(all_category_list);
              System.out.println("Hello`1123"+GridData.datavalue.toString());
            }
            else{
               System.out.println("failure");
            }

        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;

    }

    protected void onPostExecute(String resultaa) {
        System.out.println("allcategory list size"+all_category_list.size());
//       for( i=0;i<all_category_list.size();i++)
//       {
//           downloadFile(all_category_list.get(i).get("Category image"));
//       }



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
    public void downloadFile(String url) {
        String filename;
        File direct = new File(Environment.getExternalStorageDirectory()
                + "/EmojiKeyboards" + "/AllCategories");
        if (!direct.exists()) {
            direct.mkdirs();
        }

         File[] listFiles = direct.listFiles();
        if(listFiles.length!=0 && i<listFiles.length)
        {
                filename= String.valueOf(sortByNumber(listFiles));
                String filename1=filename.substring(name.lastIndexOf("/")+1);
                data=filename1.split(".jpg");
                String s=sa(data);
                System.out.println(s);
        }
      if (listFiles.length==0||!sa(data).equals(all_category_list.get(i).get("Category id"))||listFiles.length>all_category_list.size()) {
                    DownloadManager mgr = (DownloadManager) c.getSystemService(Context.DOWNLOAD_SERVICE);
                    Uri downloadUri = Uri.parse(url);
                    DownloadManager.Request request = new DownloadManager.Request(
                            downloadUri);
                    request.setAllowedNetworkTypes(DownloadManager.Request.NETWORK_WIFI | DownloadManager.Request.NETWORK_MOBILE)
                            .setAllowedOverRoaming(false).setTitle("Download Image")
                            .setDescription("Something useful. No, really.");
                    request.setDestinationInExternalPublicDir("/EmojiKeyboards" + "/AllCategories", all_category_list.get(i).get("Category id") + ".jpg");
                    mgr.enqueue(request);
                } else {
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
}
