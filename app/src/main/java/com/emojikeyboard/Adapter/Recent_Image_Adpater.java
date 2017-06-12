package com.emojikeyboard.Adapter;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.provider.MediaStore;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.RadioButton;
import android.widget.TextView;

import com.emojikeyboard.BeanClass.GridBean;
import com.emojikeyboard.MyDatabase;
import com.emojikeyboard.R;

import java.io.ByteArrayOutputStream;
import java.util.ArrayList;

/**
 * Created by Ajit on 9/7/2016.
 */
public class Recent_Image_Adpater extends BaseAdapter {
    ArrayList<String> image;
    Context context;
    Bitmap bitmap;
    GridBean gridBean;
    LayoutInflater mInflater;
    ViewHolder viewHolder ;
    MyDatabase database;
    int pos;
    public Recent_Image_Adpater(Context context, ArrayList<String> image)
    {
        this.context=context;
        this.image=image;
        mInflater = LayoutInflater.from(context);
        database=new MyDatabase(context);
    }
    @Override
    public int getCount() {
        try {
            return image.size();
        } catch (Exception e) {
            return 0;
        }
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
        if (convertView == null) {
            viewHolder = new ViewHolder();
            convertView = mInflater.inflate(R.layout.gridview_image,null);
            viewHolder.imageView = (ImageView) convertView.findViewById(R.id.imageView);
            convertView.setTag(viewHolder);
        }
        else {
            viewHolder = (ViewHolder) convertView.getTag();
        }
        Bitmap bitmap=BitmapFactory.decodeFile(image.get(position));
        viewHolder.imageView.setImageBitmap(bitmap);
        viewHolder.imageView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                database.insertimage(image.get(position));
                Bitmap bitmap1=BitmapFactory.decodeFile(image.get(position));
                Uri tempUri =  getImageUri(context, bitmap1);
                Intent shareIntent = new Intent();
                shareIntent.setAction(Intent.ACTION_SEND);
                shareIntent.setPackage(gridBean.getValue1());
                shareIntent.setType("image/png");
                shareIntent.putExtra(Intent.EXTRA_STREAM, tempUri);
                Intent share= Intent.createChooser(shareIntent, "sharing image");
                share.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                context.startActivity(share);
                share.setType("image/jpeg");
            }
        });
        return convertView;
    }
    class ViewHolder {
        ImageView imageView;
    }
    public Uri getImageUri(Context inContext, Bitmap inImage) {
        ByteArrayOutputStream bytes = new ByteArrayOutputStream();
        inImage.compress(Bitmap.CompressFormat.JPEG, 100, bytes);
        String path = MediaStore.Images.Media.insertImage(inContext.getContentResolver(),
                inImage, "Title", null);
        return Uri.parse(path);
    }
}
