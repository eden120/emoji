package com.emojikeyboard.Adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.RadioButton;
import android.widget.TextView;

import com.emojikeyboard.R;

/**
 * Created by Ajit on 9/24/2016.
 */
public class Gridview_internet_connection extends BaseAdapter {
    ViewHolder viewHolder ;
    Context context;
    LayoutInflater mInflater;
    public Gridview_internet_connection(Context context)
    {
        this.context=context;
        mInflater = LayoutInflater.from(context);
    }
    @Override
    public int getCount() {
        return 1;
    }

    @Override
    public Object getItem(int position) {
        return 0;
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (convertView == null) {
            viewHolder = new ViewHolder();
            convertView = mInflater.inflate(R.layout.internet_error,null);
            convertView.setTag(viewHolder);
        }
        else {
            viewHolder = (ViewHolder) convertView.getTag();
        }
        return convertView;
    }
    class ViewHolder {
        TextView textView;
    }
}
