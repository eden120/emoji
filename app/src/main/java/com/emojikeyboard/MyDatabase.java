package com.emojikeyboard;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

import com.emojikeyboard.Global.Global;

import java.util.ArrayList;
import java.util.HashMap;

/**
 * Created by Ajit on 6/17/2016.
 */
public class MyDatabase extends SQLiteOpenHelper {
    private final static int DATABASE_VERSION = 1;
    private static String DATABASE_NAME = "MYDATA";
    Global global;
    public ArrayList<String> recent_list = new ArrayList<String>();
    // Implementing Constructor
    public MyDatabase(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        // TODO Auto-generated method stub
        String recent_query = "Create table Recents(id integer primary key autoincrement,image text not null unique)";
        db.execSQL(recent_query);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int arg1, int arg2) {
        // TODO Auto-generated method stub
        db.execSQL("DROP TABLE IF EXISTS" + "Recents");

    }

    public void insertimage(String image) {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues values = new ContentValues();
        values.put("image", image);
        db.insert("Recents", null, values);
        System.out.println("add");
        db.close();
    }


    public String getRecents(Context context,String query) {
        global=new Global();
        String a = "error";


        SQLiteDatabase db = this.getWritableDatabase();
        Cursor resultSet = db.rawQuery(query, null);
        System.out.println("al;sj"+resultSet.getCount());
        Log.e("result set", "" + resultSet.toString());
        if (resultSet != null) {
            resultSet.moveToFirst();
        }
        do {
            HashMap<String, String> map = new HashMap<String, String>();
            try {
                String id = resultSet.getString(0);
                String image = resultSet.getString(1);
                map.put("recent_id",id);
                map.put("image", image);
                recent_list.add(map.get("image"));
                // a = "true";
            }

            catch (IndexOutOfBoundsException e) {
                e.printStackTrace();
            }

        } while (resultSet.moveToNext());
        Log.e("list artist", recent_list.toString());
        global.setImage(recent_list);
        return a;
    }

    public void delete(Context context,String PK_ID,String colomn_name,String table_name) {
        // TODO Auto-generated method stub

        SQLiteDatabase db = this.getWritableDatabase();

        db.delete(table_name, colomn_name + " = ?", new String[] { PK_ID.toString() });
        Log.e("My PATH", PK_ID);

    }


}