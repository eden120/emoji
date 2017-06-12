package com.emojikeyboard.Adapter;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
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

import java.util.ArrayList;

/**
 * Created by Ajit on 9/5/2016.
 */
public class FontAdapter extends BaseAdapter {
    Context context;
    LayoutInflater mInflater;
    private RadioButton mSelectedRB;
    private int mSelectedPosition = -1;
    ViewHolder viewHolder ;
    ArrayList<String> values=new ArrayList<String>();
    SharedPreferences sharedpreferences;
    String mypreference = "mypref";
    public FontAdapter(Context context, ArrayList<String> values) {
        this.context=context;
        mInflater = LayoutInflater.from(context);
        this.values=values;
    }

    @Override
    public int getCount() {
        return values.size();
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
        sharedpreferences  = context.getSharedPreferences(mypreference, Context.MODE_PRIVATE);
        if (convertView == null) {
            viewHolder = new ViewHolder();
            convertView = mInflater.inflate(R.layout.gridview_fonts_adpater,null);
            viewHolder.textView = (TextView) convertView.findViewById(R.id.text_value);
            viewHolder.radiobutton = (RadioButton) convertView.findViewById(R.id.check);
            convertView.setTag(viewHolder);
        }
        else {
            viewHolder = (ViewHolder) convertView.getTag();
        }
        viewHolder.textView.setText(values.get(position));
        viewHolder.radiobutton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SharedPreferences.Editor editor = sharedpreferences.edit();
                if(position != mSelectedPosition && mSelectedRB != null){
                    mSelectedRB.setChecked(false);
                }
                mSelectedPosition = position;
                editor.putInt("font", position);
                editor.apply();
                Toast.makeText(context,"Theme "+ position+" is selected", Toast.LENGTH_SHORT).show();
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
        TextView textView;
        RadioButton radiobutton;
    }
}
