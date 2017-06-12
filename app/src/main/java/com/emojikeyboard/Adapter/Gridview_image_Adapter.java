package com.emojikeyboard.Adapter;

import android.content.Context;
import android.content.SharedPreferences;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.RadioButton;
import android.widget.TextView;
import android.widget.Toast;

import com.emojikeyboard.R;

/**
 * Created by Ajit on 8/17/2016.
 */
public class Gridview_image_Adapter extends BaseAdapter {
    LayoutInflater mInflater;
    Context ctx;
    int value;
    private RadioButton mSelectedRB;
    private int mSelectedPosition = -1;
    ViewHolder viewHolder ;
    String[] prgmNameList;
    int[] prgmImages;
    String [] result;

    SharedPreferences sharedpreferences;
    String mypreference = "mypref";
    int [] imageId;
    public Gridview_image_Adapter(Context c, String[] prgmNameList, int[] Images)
    {
        ctx=c;
        result=prgmNameList;
        imageId=Images;
        this.prgmNameList=prgmNameList;
        this.prgmImages=prgmImages;
        mInflater = LayoutInflater.from(ctx);

    }
    @Override
    public int getCount() {
        return result.length;
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

        sharedpreferences  = ctx.getSharedPreferences(mypreference, Context.MODE_PRIVATE);


        if (convertView == null) {
            viewHolder = new ViewHolder();
            convertView = mInflater.inflate(R.layout.gridview_emoji_adapter,null);
            viewHolder.imageView = (ImageView) convertView.findViewById(R.id.emoji_image);
            viewHolder.textView = (TextView) convertView.findViewById(R.id.emoji_text);
            viewHolder.radiobutton1 = (RadioButton) convertView.findViewById(R.id.emoji_checkbox);
            convertView.setTag(viewHolder);
        }
        else {
            viewHolder = (ViewHolder) convertView.getTag();
        }
        viewHolder.textView.setText(result[position]);
        viewHolder.imageView.setImageResource(imageId[position]);
        viewHolder.radiobutton1.setOnClickListener(new View.OnClickListener() {
            SharedPreferences.Editor editor = sharedpreferences.edit();
            @Override
            public void onClick(View v) {

                if(position != mSelectedPosition && mSelectedRB != null){
                    mSelectedRB.setChecked(false);
                }
                mSelectedPosition = position;
                System.out.println(position);
                editor.putInt("image", position);
                editor.apply();
                Toast.makeText(ctx, prgmNameList[position]+" is selected", Toast.LENGTH_SHORT).show();
                mSelectedRB = (RadioButton)v;
            }
        });

        if(mSelectedPosition != position){
            viewHolder.radiobutton1.setChecked(false);
        }else{
            viewHolder.radiobutton1.setChecked(true);
            if(mSelectedRB != null && viewHolder.radiobutton1 != mSelectedRB){
                mSelectedRB = viewHolder.radiobutton1;
            }
        }
        return convertView;
    }
    class ViewHolder {
        ImageView imageView;
        TextView textView;
        RadioButton radiobutton1;
    }
}
