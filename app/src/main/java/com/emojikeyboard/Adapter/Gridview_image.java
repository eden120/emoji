package com.emojikeyboard.Adapter;

import android.app.DownloadManager;
import android.content.Context;
import android.content.ContextWrapper;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.Environment;
import android.provider.MediaStore;
import android.support.v4.content.FileProvider;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.ImageView;

import com.emojikeyboard.BeanClass.Copy_image_bean;
import com.emojikeyboard.BeanClass.GridBean;
import com.emojikeyboard.BeanClass.GridData;
import com.emojikeyboard.BeanClass.GridValue;
import com.emojikeyboard.Copy_image;
import com.emojikeyboard.MyDatabase;
import com.emojikeyboard.R;
import com.emojikeyboard.sqlite.EmojiSQLiteHelper;
import com.squareup.picasso.Picasso;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;
import java.util.Comparator;
import java.util.HashMap;

/**
 * Created by Ajit on 8/24/2016.
 */
public class Gridview_image extends BaseAdapter {
    Context context;
    ViewHolder viewHolder ;
    ViewGroup viewgroup;
    ArrayList<String> image;
    LayoutInflater mInflater;
    MyDatabase database;
    GridBean gridBean;
    GridValue gridValue;
    int i,pos;
    SharedPreferences sharedpreferences;
    String mypreference = "mypref";
    String value1,value2;
    String name1;
    GridData gridData;
    Copy_image_bean copyImageBean;
    Copy_image copy_image;
    public Gridview_image(Context context, ArrayList<String> image, String name1,int pos)
    {
        this.context=context;
        this.image=image;
        this.name1=name1;
        this.pos=pos;
        database=new MyDatabase(context);
        mInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }

    @Override
    public int getCount() {
        return image.size();
    }

    @Override
    public Object getItem(int position) {
        return null;
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @Override
    public View getView(final int position, View convertView, ViewGroup parent) {
        gridBean=new GridBean();
        gridData=new GridData();
        gridValue=new GridValue();
        copyImageBean=new Copy_image_bean();
        copy_image=new Copy_image();
        viewHolder = null;
        viewgroup = parent;
        if (convertView == null) {
            viewHolder = new ViewHolder();
            convertView = mInflater.inflate(R.layout.gridview_image, null);
            viewHolder.imageView = (ImageView) convertView.findViewById(R.id.imageView);
            convertView.setTag(viewHolder);
        }
        else {
            viewHolder = (ViewHolder) convertView.getTag();
        }
        viewHolder.imageView.setTag(position);
        if(hasConnection()==true)
        {
                Picasso.with(context).load(image.get(position)).placeholder(R.drawable.progress_animation)   // optional
                .error(R.drawable.emoji_icon)      // optional
                .resize(70, 70)
                .into( viewHolder.imageView);
        }
        else
        {
            Collections.sort(image);
            Bitmap bitmap=BitmapFactory.decodeFile(image.get(position));
            viewHolder.imageView.setImageBitmap(bitmap);
        }

        viewHolder.imageView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if(hasConnection()==true) {

                    String id1="";
                    if(pos==1)
                    {
                        copy_image.griddata("smiley",pos);
                        Collections.sort(copyImageBean.getValue1());
                        id1=copyImageBean.getValue1().get(position);
                        System.out.println("id1"+id1);
                    }
                    else if(pos==2)
                    {
                        copy_image.griddata("sports",pos);
                        Collections.sort(copyImageBean.getValue2());
                        id1=copyImageBean.getValue2().get(position);
                    }
                    else
                    {
                        copy_image.griddata("weather",pos);
                        Collections.sort(copyImageBean.getValue3());
                        id1=copyImageBean.getValue3().get(position);
                    }
                   // Bitmap bitmap= BitmapFactory.decodeFile(id1);
                    database.insertimage(id1);
                   // Uri tempUri =  getImageUri(context, bitmap);
                    Intent shareIntent = new Intent();
                    shareIntent.setAction(Intent.ACTION_SEND);
                    shareIntent.setType("image/png");
                    System.out.println("id1"+id1);
                    Uri tempUri = FileProvider.getUriForFile(context, "com.myfileprovider", new File(id1));
                    tempUri.getPath();
                    shareIntent.setPackage(gridBean.getValue1());
                    //shareIntent.setDataAndType(tempUri,"share");
                    shareIntent.addFlags(Intent.FLAG_GRANT_READ_URI_PERMISSION);
                    shareIntent.addFlags( Intent.FLAG_GRANT_WRITE_URI_PERMISSION );
                    shareIntent.putExtra(Intent.EXTRA_STREAM, tempUri);
                    //context.startActivity(Intent.createChooser(shareIntent, "sahring image"));
                    Intent share= Intent.createChooser(shareIntent, "sharing image");
                    share.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                    context.startActivity(share);
//                    share.setType("image/jpeg");
                }
                else
                {
                    System.out.println(pos);
                    String id="";
                    if(pos==1)
                    {
                        Collections.sort(gridValue.getData1());
                        id=gridValue.getData1().get(position);
//                    String filename=id.substring(id.lastIndexOf("/")+1);
                        System.out.println(id);
                    }
                    else if(pos==2)
                    {
                        Collections.sort(gridValue.getData2());
                        id=gridValue.getData2().get(position);
//                    String filename=id.substring(id.lastIndexOf("/")+1);
                        System.out.println(id);
                    }
                    else {
                        Collections.sort(gridValue.getData3());
                        id = gridValue.getData3().get(position);
//                    String filename=id.substring(id.lastIndexOf("/")+1);
                        System.out.println(id);
                    }
                    Bitmap bitmap= BitmapFactory.decodeFile(id);
                    database.insertimage(id);
                    Uri tempUri =  getImageUri(context, bitmap);
                    Intent shareIntent = new Intent();
                    shareIntent.setAction(Intent.ACTION_SEND);
                    shareIntent.setPackage(gridBean.getValue1());
                    shareIntent.setType("image/png");
                    shareIntent.addFlags(Intent.FLAG_GRANT_READ_URI_PERMISSION);
                    shareIntent.putExtra(Intent.EXTRA_STREAM, tempUri);
                    Intent share= Intent.createChooser(shareIntent, "sharing image");
                    share.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                    context.startActivity(share);
                    share.setType("image/jpeg");
                }

            }
        });

        return convertView;
    }
    public Uri getImageUri(Context inContext, Bitmap inImage) {
        ByteArrayOutputStream bytes = new ByteArrayOutputStream();
        inImage.compress(Bitmap.CompressFormat.JPEG, 100, bytes);
        String path = MediaStore.Images.Media.insertImage(inContext.getContentResolver(),
                inImage, "Title", null);
        return Uri.parse(path);
    }

    class ViewHolder {
        ImageView imageView;
    }

    public  boolean hasConnection() {

        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo wifiNetwork = cm.getNetworkInfo(ConnectivityManager.TYPE_WIFI);
        if (wifiNetwork != null && wifiNetwork.isConnected()) {
            return true;
        }

        NetworkInfo mobileNetwork = cm.getNetworkInfo(ConnectivityManager.TYPE_MOBILE);
        if (mobileNetwork != null && mobileNetwork.isConnected()) {
            return true;
        }

        NetworkInfo activeNetwork = cm.getActiveNetworkInfo();
        if (activeNetwork != null && activeNetwork.isConnected()) {
            return true;
        }

        return false;
    }
}
