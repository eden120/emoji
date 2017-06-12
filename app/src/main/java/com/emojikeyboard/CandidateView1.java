package com.emojikeyboard;

import android.content.Context;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Environment;
import android.util.TypedValue;
import android.view.View;
import android.widget.AbsListView;
import android.widget.GridView;
import android.widget.ListView;

import com.emojikeyboard.Adapter.Gridview_image;
import com.emojikeyboard.Adapter.Gridview_internet_connection;
import com.emojikeyboard.Adapter.Recent_Image_Adpater;
import com.emojikeyboard.Api.Get_category_Api_2;
import com.emojikeyboard.BeanClass.GridBean;
import com.emojikeyboard.BeanClass.GridBean1;
import com.emojikeyboard.BeanClass.GridData;
import com.emojikeyboard.BeanClass.GridValue;
import com.emojikeyboard.Global.Global;


import java.io.File;
import java.util.ArrayList;

/**
 * Created by Ajit on 8/31/2016.
 */
public class CandidateView1 {
    private int position;
    private Context context;
    private ArrayList<String> recents;
     GridView emojiGrid;
    ListView listView;
    private GridData gridData;
    Get_category_Api_2 get_category_api_2;
    ArrayList<String> cat_id;
    private int pageCount = 0,k;
    private int currentPage = 0;
    private int previousTotal = 0;
    private boolean loading = true;
    private int visibleThreshold = 5;
    private ArrayList<String> bitmaapArray_list;
    private ArrayList<String> bitmapArray;
    private ArrayList<GridBean1> gridbeen;
    private GridBean1 gridBean;
    private File[] allFiles;
    private int pos,image,sdk;
    GridValue gridValue;
    Global global;
    String mypreference = "mypref";
    SharedPreferences sharedpreferences;

    public CandidateView1(Context context, int position,int pos) {
        this.context = context;
        this.position = position;
        this.pos=pos;
        gridBean = new GridBean1();
    }

    public CandidateView1(Context context, int position, ArrayList<String> recents,int pos) {
        this(context, position,pos);
        this.recents = recents;
    }

    public View getView() {
        sharedpreferences = context.getSharedPreferences(mypreference, Context.MODE_PRIVATE);
         emojiGrid = new GridView(context);
        gridData=new GridData();
        gridValue=new GridValue();
        global=new Global();
        emojiGrid.setColumnWidth((int) TypedValue.applyDimension(TypedValue.COMPLEX_UNIT_DIP, 50, context.getResources().getDisplayMetrics()));
        emojiGrid.setNumColumns(2);
       // emojiGrid.setOnScrollListener(new EndlessScrollListener(context));
        //emojiGrid.setOnScrollListener(onScrollListener());

        image=sharedpreferences.getInt("image",0);
        sdk = android.os.Build.VERSION.SDK_INT;
        if(image==1)
        {
            if(sdk < android.os.Build.VERSION_CODES.JELLY_BEAN) {
                emojiGrid.setBackgroundDrawable( context.getResources().getDrawable(R.drawable.bg1) );
            } else {
                emojiGrid.setBackground( context.getResources().getDrawable(R.drawable.bg1));
            }
        }
        else if(image==2)
        {
            if(sdk < android.os.Build.VERSION_CODES.JELLY_BEAN) {
                emojiGrid.setBackgroundDrawable( context.getResources().getDrawable(R.drawable.bg2) );
            } else {
                emojiGrid.setBackground( context.getResources().getDrawable(R.drawable.bg2));
            }
        }
        else
        {
            if(sdk < android.os.Build.VERSION_CODES.JELLY_BEAN) {
                emojiGrid.setBackgroundDrawable( context.getResources().getDrawable(R.drawable.bg3) );
            } else {
                emojiGrid.setBackground( context.getResources().getDrawable(R.drawable.bg3));
            }
        }

        cat_id=new ArrayList<String>();

        for(int i = 0; i< GridData.datavalue.size(); i++)
        {
            String value=GridData.datavalue.get(i).get("Category id");
                                 cat_id.add(value);
        }
        if (position == 0)
        {
            emojiGrid.setAdapter(new Recent_Image_Adpater(context, global.getImage()));
        }
        else if(position==1)
        {
            if(hasConnection()==true)
            {
                get_category_api_2=new Get_category_Api_2(context,emojiGrid,position,pos);
                //get_category_api_2.execute(GridData.datavalue.get(0).get("Category id"),"1");
                get_category_api_2.execute("60","1");
            }
            else {
                    System.out.println("smiley");
                    griddata("smiley");
                    emojiGrid.setAdapter(new Gridview_image(context, gridBean.getImage(), "smiley", position));

            }
        }
        else if(position==2)
        {
            if(hasConnection()==true)
            {
                get_category_api_2=new Get_category_Api_2(context,emojiGrid,position,pos);
//            get_category_api_2.execute(GridData.datavalue.get(1).get("Category id"),"1");
                get_category_api_2.execute("61","1");
            }
           else {
                griddata("sports");
                    emojiGrid.setAdapter(new Gridview_image(context,gridBean.getImage(),"sports",position));
                }
                System.out.println("sports");
        }
        else
        {
            if (hasConnection()==true)
            {
                get_category_api_2=new Get_category_Api_2(context,emojiGrid,position,pos);
//            get_category_api_2.execute(GridData.datavalue.get(2).get("Category id"),"1");
                get_category_api_2.execute("63","1");
            }
            else {
                    griddata("weather");
                    emojiGrid.setAdapter(new Gridview_image(context, gridBean.getImage(), "weather", position));
            }
        }
            return emojiGrid;
    }

    public View getView1() {
        listView=new ListView(context);
        listView.setAdapter(new Gridview_internet_connection(context));
        listView.setAdapter(new Gridview_internet_connection(context));
        listView.setAdapter(new Gridview_internet_connection(context));
        listView.setAdapter(new Gridview_internet_connection(context));
        return listView;
    }
    private AbsListView.OnScrollListener onScrollListener() {
        return new AbsListView.OnScrollListener() {

            @Override
            public void onScrollStateChanged(AbsListView view, int scrollState) {
                int threshold = 1;
                int total_count= Integer.parseInt(gridData.getTotal_page());

                int count = emojiGrid.getCount();

                if (scrollState == SCROLL_STATE_IDLE) {

                        System.out.println("load more data");
                        // Execute LoadMoreDataTask AsyncTask
                        if(position==1)
                        {
                            if (emojiGrid.getLastVisiblePosition() >=total_count) {
                                System.out.println("total_count"+total_count);
                                System.out.println("aat"+cat_id.size());
                                //get_category_api_2=new Get_category_Api_2(context,emojiGrid,1);
//                                get_category_api_2.execute(GridData.datavalue.get(0).get("Category id"),"2");
                                get_category_api_2.execute("51","2");
                            }
                        }
                        else if(position==2)
                        {
                            if (emojiGrid.getLastVisiblePosition() >=total_count) {
                                System.out.println("total_count"+total_count);
                              //  get_category_api_2=new Get_category_Api_2(context,emojiGrid,2);
//                                get_category_api_2.execute(GridData.datavalue.get(1).get("Category id"),"2");
                                get_category_api_2.execute("52","2");
                            }
                        }
                        else
                        {
                            if (emojiGrid.getLastVisiblePosition() >=total_count) {
                                System.out.println("total_count"+total_count);
                               // get_category_api_2=new Get_category_Api_2(context,emojiGrid,3);
//                                get_category_api_2.execute(GridData.datavalue.get(2).get("Category id"),"2");
                                get_category_api_2.execute("56","2");
                            }
                        }
                        // /getDataFromUrl(url_page2);
                }
            }
            @Override
            public void onScroll(AbsListView view, int firstVisibleItem, int visibleItemCount,
                                 int totalItemCount) {
            }
        };
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
    public void griddata(String data) {
        bitmaapArray_list = new ArrayList<String>();
        bitmapArray=new ArrayList<String>();
        gridbeen = new ArrayList<GridBean1>();

        File folder = new File(Environment.getExternalStorageDirectory().getPath() + "/EmojiKeyboards" + "/" + data);
        if (folder.isDirectory()) {
            allFiles = folder.listFiles();
            for (int i = 0; i < allFiles.length; i++) {
                String s = allFiles[i].getAbsolutePath();
                String s1=allFiles[i].getName();
                bitmaapArray_list.add(s);
                bitmapArray.add(s1);
                if(position==1)
                {
                    gridValue.setData1(bitmaapArray_list);
                    gridValue.setData4(bitmapArray);
                }
                else if(position==2)
                {
                    gridValue.setData2(bitmaapArray_list);
                    gridValue.setData5(bitmapArray);
                }
                else
                {
                    gridValue.setData3(bitmaapArray_list);
                    gridValue.setData6(bitmapArray);
                }
                gridBean.setImage(bitmaapArray_list);
                gridbeen.add(gridBean);
                System.out.println("hello" + s);
            }
        }
     }
}
