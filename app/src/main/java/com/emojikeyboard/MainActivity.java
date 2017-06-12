package com.emojikeyboard;

import android.Manifest;
import android.app.Activity;
import android.content.pm.PackageManager;
import android.os.Build;
import android.os.Bundle;
import android.support.v4.app.ActivityCompat;
import android.view.View;
import android.widget.Button;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;


import com.emojikeyboard.Adapter.Emoji_gridView_Adapter;
import com.emojikeyboard.Adapter.Gridview_image_Adapter;
import com.emojikeyboard.Extra.Common;
import com.jeremyfeinstein.slidingmenu.lib.SlidingMenu;

public class MainActivity extends Activity {
    GridView gridView;
    SlidingMenu menu;
    ImageView img;
    public TextView textView;
    RelativeLayout title;
    Button emoji_button,english_button;
    public static int [] prgmeng={R.drawable.e3,R.drawable.e2,R.drawable.e1};
    public static int [] prgmImages={R.drawable.i1,R.drawable.i3,R.drawable.i2};
    public static String [] prgmName_eng={"English Theme 1","English Theme 2","English Theme 3"};

    public static String [] prgmName_images={"Emoji Theme 1","Emoji Theme 2","Emoji Theme 3"};


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        title= (RelativeLayout) findViewById(R.id.title_style);
        gridView= (GridView) findViewById(R.id.grid_view);
        emoji_button= (Button) findViewById(R.id.button1);
        english_button= (Button) findViewById(R.id.button2);
        img= (ImageView) findViewById(R.id.menu);
        textView= (TextView) findViewById(R.id.title_text);
        menu= Common.setSlidingMenu(MainActivity.this,title,false);
        new SlidMenuFunction(menu,MainActivity.this);
        textView.setText("Home");
        gridView.setAdapter(new Gridview_image_Adapter(MainActivity.this,prgmName_images,prgmImages));
        emoji_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                gridView.setAdapter(new Gridview_image_Adapter(MainActivity.this,prgmName_images,prgmImages));
            }
        });
        english_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                gridView.setAdapter(new Emoji_gridView_Adapter(MainActivity.this,prgmName_eng,prgmeng));
            }
        });
        img.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                menu.showMenu();
            }
        });


    }


    public  boolean isStoragePermissionGranted() {
        if (Build.VERSION.SDK_INT >= 23) {
            if (checkSelfPermission(android.Manifest.permission.WRITE_EXTERNAL_STORAGE)
                    == PackageManager.PERMISSION_GRANTED) {
                return true;
            } else {


                ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.WRITE_EXTERNAL_STORAGE}, 1);
                return false;
            }
        }
        else { //permission is automatically granted on sdk<23 upon installation
            return true;
        }


    }
//    @Override
//    public void onRequestPermissionsResult(int requestCode, String[] permissions, int[] grantResults) {
//        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
//        if(grantResults[0]== PackageManager.PERMISSION_GRANTED){
//        }
//    }
}
