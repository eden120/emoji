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
import com.emojikeyboard.SlidMenuFunction;


public class Emoji_gridView_Adapter extends BaseAdapter {
    LayoutInflater mInflater;
    Context ctx;
    private RadioButton mSelectedRB;
    private int mSelectedPosition = -1;
    ViewHolder viewHolder ;
    String[] prgmNameList;
    int[] prgmeng;
    String [] result;
    int [] imageId;
    SharedPreferences sharedpreferences;
    String mypreference = "mypref";
    public Emoji_gridView_Adapter(Context c, String[] prgmNameList, int[] prgmeng)
    {
        ctx=c;
        result=prgmNameList;
        imageId=prgmeng;
        this.prgmeng=prgmeng;
        this.prgmNameList=prgmNameList;
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
            convertView = mInflater.inflate(R.layout.grid_view_adapter,null);
           viewHolder.imageView = (ImageView) convertView.findViewById(R.id.image);
            viewHolder.textView = (TextView) convertView.findViewById(R.id.text);
            viewHolder.radiobutton = (RadioButton) convertView.findViewById(R.id.checkbox);
            convertView.setTag(viewHolder);
        }
        else {
            viewHolder = (ViewHolder) convertView.getTag();
        }
        viewHolder.textView.setText(result[position]);
        viewHolder.imageView.setImageResource(imageId[position]);
        viewHolder.radiobutton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SharedPreferences.Editor editor = sharedpreferences.edit();
                if(position != mSelectedPosition && mSelectedRB != null){
                    mSelectedRB.setChecked(false);
                }
                mSelectedPosition = position;
                editor.putInt("value1", position);
                editor.apply();
                Toast.makeText(ctx, prgmNameList[position]+" is selected", Toast.LENGTH_SHORT).show();
                mSelectedRB = (RadioButton)v;
            }
        });

        if(mSelectedPosition != position){
            viewHolder.radiobutton.setChecked(false);
        }else{
            viewHolder.radiobutton.setChecked(true);
            if(mSelectedRB != null && viewHolder.radiobutton != mSelectedRB){
                mSelectedRB = viewHolder.radiobutton;
            }
        }
        return convertView;
    }
    class ViewHolder {
        ImageView imageView;
        TextView textView;
        RadioButton radiobutton;
    }
}
