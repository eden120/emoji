package com.emojikeyboard.Extra;


import android.app.Activity;
import android.content.Context;
import android.view.Display;
import android.view.View;

import com.emojikeyboard.R;
import com.jeremyfeinstein.slidingmenu.lib.SlidingMenu;


public class Common {

	static SlidingMenu menu;
	@SuppressWarnings("deprecation")
	public static int setWidth(Context c) {
		Display display = ((Activity) c).getWindowManager().getDefaultDisplay();

		int w = display.getWidth();

		int width = ((w / 2) +20);

		return width;

	}
	public static SlidingMenu setSlidingMenu(Context c , View slide, boolean b) {
		
		
		menu = new SlidingMenu(c);
	
		try {
			menu.setFadeDegree(1.0f);
			menu.setBehindWidth(Common.setWidth(c));
			menu.attachToActivity((Activity) c, SlidingMenu.SLIDING_CONTENT);
			menu.setMenu(R.layout.activity_sliding_menu);
			menu.setMode(SlidingMenu.LEFT);
			
			
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		if(b)
		{
			menu.addIgnoredView(slide);
		}
		
		return menu;
	}
	
	public void menu(final Context c){
		menu.showMenu();		
	}
	
	
	
	
	
	}
