package com.emojikeyboard;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.res.AssetManager;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.GridView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.emojikeyboard.Adapter.AboutAdapter;
import com.emojikeyboard.Adapter.Emoji_gridView_Adapter;
import com.emojikeyboard.Adapter.FontAdapter;
import com.emojikeyboard.Adapter.Gridview_image_Adapter;
import com.emojikeyboard.BeanClass.GridData;
import com.jeremyfeinstein.slidingmenu.lib.SlidingMenu;

import java.io.IOException;
import java.sql.Array;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class SlidMenuFunction {
    RelativeLayout home, about, exit, font;
    SlidingMenu menu;
    private GridView gridView;
    private ListView listView;
    private Button button1,button2;
    Context c;
    private LinearLayout linaer;
    private TextView text;
    ArrayList <String> gridvalue;
    GridData gridData;
    MainActivity mainActivity;
    public SlidMenuFunction(final SlidingMenu menu, final Context c) {
        this.menu = menu;
        this.c = c;
        mainActivity=new MainActivity();
        font = (RelativeLayout) menu.findViewById(R.id.font);
        about= (RelativeLayout) menu.findViewById(R.id.about);
        home= (RelativeLayout) menu.findViewById(R.id.home1);
        exit= (RelativeLayout) menu.findViewById(R.id.exit);
        gridView = (GridView) menu.findViewById(R.id.grid_view);
        listView= (ListView) menu.findViewById(R.id.lisview);
        text= (TextView) menu.findViewById(R.id.title_text);
        button1= (Button) menu.findViewById(R.id.button1);
        button2= (Button) menu.findViewById(R.id.button2);
        linaer= (LinearLayout) menu.findViewById(R.id.button);
        gridData=new GridData();
        gridvalue=new ArrayList<String>();

        font.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                menu.toggle();
                linaer.setVisibility(View.VISIBLE);
                gridvalue.clear();
                text.setText("Font");
                Copyassets("fonts");
                gridView.setVisibility(View.VISIBLE);
                gridView.setAdapter(new FontAdapter(c,gridData.getValue()));
            }
        });

        home.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                menu.toggle();
                text.setText("Home");
                linaer.setVisibility(View.VISIBLE);
                gridView.setVisibility(View.VISIBLE);
                gridView.setAdapter(new Emoji_gridView_Adapter(c, MainActivity.prgmName_eng, MainActivity.prgmeng));
            }
        });
        about.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                menu.toggle();
                listView.setVisibility(View.VISIBLE);
                gridView.setVisibility(View.GONE);
                text.setText("About Us");
                linaer.setVisibility(View.GONE);
                //mainActivity.textView.setText("About Us");
                listView.setAdapter(new AboutAdapter(c));

            }
        });

        exit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ((Activity)c).finish();
            }
        });

        button1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                text.setText("About Us");
                gridView.setVisibility(View.VISIBLE);
                gridView.setAdapter(new Gridview_image_Adapter(c, MainActivity.prgmName_images, MainActivity.prgmImages));
            }
        });

        button2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                text.setText("About Us");
                gridView.setVisibility(View.VISIBLE);
                gridView.setAdapter(new Emoji_gridView_Adapter(c, MainActivity.prgmName_eng, MainActivity.prgmeng));
            }
        });
}
    public void Copyassets(String path) {
        AssetManager assetManager = c.getAssets();
        String[] assets = null;
        try {
            Log.i("tag", "Copyassets() " + path);
            System.out.println("path" + path);
            assets = assetManager.list(path);
           for(int i=0;i<assets.length;i++)
           {
               String name=assets[i];
              String[] data=name.split(".ttf");
               //System.out.println(Arrays.toString(data));

               String output ="";
               for(String str: data)
                   output=output+str;
               gridvalue.add(output);
               gridData.setValue(gridvalue);
           }

        } catch (IOException ex) {
            Log.e("tag", "I/O Exception", ex);
        }
    }
}