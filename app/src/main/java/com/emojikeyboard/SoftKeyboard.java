package com.emojikeyboard;


import android.annotation.TargetApi;
import android.app.ActivityManager;
import android.app.AppOpsManager;
import android.app.usage.UsageStats;
import android.app.usage.UsageStatsManager;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.res.AssetManager;
import android.content.res.Resources;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.Drawable;
import android.inputmethodservice.InputMethodService;
import android.inputmethodservice.Keyboard;
import android.inputmethodservice.KeyboardView;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.Build;
import android.os.Environment;
import android.provider.Settings;
import android.support.v4.view.PagerAdapter;
import android.support.v4.view.ViewPager;
import android.text.Spannable;
import android.text.SpannableString;
import android.text.method.MetaKeyKeyListener;
import android.text.style.ImageSpan;
import android.util.Base64;
import android.util.Log;
import android.view.Display;
import android.view.KeyCharacterMap;
import android.view.KeyEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.WindowManager;
import android.view.inputmethod.CompletionInfo;
import android.view.inputmethod.EditorInfo;
import android.view.inputmethod.InputConnection;
import android.view.inputmethod.InputMethodManager;
import android.widget.GridView;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import com.astuetz.PagerSlidingTabStrip;
import com.emojikeyboard.Api.All_Categories_Api;
import com.emojikeyboard.BeanClass.GridBean;
import com.emojikeyboard.BeanClass.GridBean1;
import com.emojikeyboard.BeanClass.GridData;
import com.emojikeyboard.Global.Global;
import com.emojikeyboard.sqlite.EmojiDataSource;
import com.emojikeyboard.sqlite.Recent;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Date;
import java.util.List;

public class SoftKeyboard extends InputMethodService implements KeyboardView.OnKeyboardActionListener {

	static final boolean DEBUG = false;
	private ViewPager vp;
	private static MyPagerAdapter adapter;
	private static Emoji_MyPagerAdapter emoji_adapter;
	private PagerSlidingTabStrip tabs;
	static int inputvalue = 0;
	private static InputConnection input;
	private StringBuilder mComposing;
	static Boolean state = false;
	private long mLastShiftTime;
	private boolean mCapsLock;
	private String mWordSeparators;
	private GridView gridview;
	private View popUpView;
	private boolean mPredictionOn;
	private KeyboardView mInputView;
	private EmojiKeyboard mQwertyKeyboard;
	private EmojiKeyboard mSymbolsKeyboard;
	private EmojiKeyboard mSymbolsShiftedKeyboard;
	private long mMetaState;
	private boolean mCompletionOn;
	private Resources mResources;
	private CandidateView mCandidateView;
	private CompletionInfo[] mCompletions;
	ImageButton delete;
	Context ctx;
	String[] images;
	Bitmap bitmap[];
	String data[];
	Uri uri[];
	private int keyboardHeight;
	ArrayList<Bitmap> bmp, bmp_soccer;
	ArrayList<String> emojiarray;
	String foldername;
	Global global;
	ArrayList<GridBean> gridbeen;
	ArrayList<String> bitmaapArray_list;
	File[] allFiles;
	File[] all_category_list;
	GridBean gridBean;
	LinearLayout layout;
	LinearLayout layout1;
	private EmojiKeyboard mCurKeyboard;
	private static ActivityManager mActivityManager;
	private static EmojiDataSource dataSource;
	int[] codes = {800, 801, 802, 901, 902, 903, 904, 905, 906, 907, 908, 909, 910, 911, 912};
	int[] emojicodes = {600, 601, 602, 701, 702, 703, 704, 705, 706, 707, 708, 709, 710, 711, 712};
	SharedPreferences sharedpreferences;
	String mypreference = "mypref";
	int value1,font,image,sdk;
	ProcessManager processManager;
	MyDatabase database;
	public static ArrayList<Recent> recents_emoji;
	private static ArrayList<String> recents;
	All_Categories_Api all_categories_api;
	ArrayList<String> all_category;
	private int mLastDisplayWidth;
	GridData gridData;
    ArrayList<String> cat_name;

	public SoftKeyboard() {
		this.mComposing = new StringBuilder();
	}

	private void checkToggleCapsLock() {
		long now = System.currentTimeMillis();
		if (this.mLastShiftTime + 800 > now) {
			this.mCapsLock = !this.mCapsLock;
			this.mLastShiftTime = 0;
		} else {
			this.mLastShiftTime = now;
		}
	}

	private void commitTyped(InputConnection inputConnection) {
		if (this.mComposing.length() > 0) {
			inputConnection.commitText(this.mComposing, 1);        // mComposing.length()
			mComposing.setLength(0);
			this.updateCandidates();
		}
	}

	private String getWordSeparators() {
		mInputView.setPreviewEnabled(true);
		return this.mWordSeparators;
	}


	private void handleCharacter(int primaryCode, int[] keyCodes) {
		mInputView.setPreviewEnabled(true);
		if (isInputViewShown()) {
			if (this.mInputView.isShifted()) {
				primaryCode = Character.toUpperCase(primaryCode);
			}
		}
		if (this.isAlphabet(primaryCode) && this.mPredictionOn) {
			mInputView.setPreviewEnabled(true);
			this.mComposing.append((char) primaryCode);
			this.getCurrentInputConnection().setComposingText(this.mComposing, 1);
			this.updateShiftKeyState(this.getCurrentInputEditorInfo());
			mInputView.setPreviewEnabled(true);
			this.updateCandidates();
		} else {
			//mInputView.setPreviewEnabled(false);
			this.mComposing.append((char) primaryCode);
			mInputView.setPreviewEnabled(true);
			this.getCurrentInputConnection().setComposingText(this.mComposing, 1);
		}
	}

	private void handleClose() {
		commitTyped(this.getCurrentInputConnection());
		this.requestHideSelf(0);
		this.mInputView.closing();
	}

	private void handleShift() {
		if (this.mInputView == null) {
			return;
		}

		Keyboard currentKeyboard = this.mInputView.getKeyboard();
		if (this.mQwertyKeyboard == currentKeyboard) {

			this.checkToggleCapsLock();
			this.mInputView.setShifted(this.mCapsLock || !this.mInputView.isShifted());

		} else if (currentKeyboard == this.mSymbolsKeyboard) {

			this.mSymbolsKeyboard.setShifted(true);
			this.mInputView.setKeyboard(this.mSymbolsShiftedKeyboard);
			this.mSymbolsShiftedKeyboard.setShifted(true);

		} else if (currentKeyboard == this.mSymbolsShiftedKeyboard) {

			this.mSymbolsShiftedKeyboard.setShifted(false);
			this.mInputView.setKeyboard(this.mSymbolsKeyboard);
			this.mSymbolsKeyboard.setShifted(false);

		}
	}

	private boolean isAlphabet(int code) {
		return Character.isLetter(code);
	}

	private void keyDownUp(int keyEventCode) {
		getCurrentInputConnection().sendKeyEvent(new KeyEvent(KeyEvent.ACTION_DOWN, keyEventCode));
		getCurrentInputConnection().sendKeyEvent(new KeyEvent(KeyEvent.ACTION_UP, keyEventCode));
	}

	private void sendKey(int keyCode) {
		switch (keyCode) {
			case '\n':
				mInputView.setPreviewEnabled(true);
				keyDownUp(KeyEvent.KEYCODE_ENTER);
				keyDownUp(KeyEvent.KEYCODE_SEARCH);
				break;
			default:
				if (keyCode >= '0' && keyCode <= '9') {
					mInputView.setPreviewEnabled(true);
					keyDownUp(keyCode - '0' + KeyEvent.KEYCODE_0);
				} else {
					mInputView.setPreviewEnabled(false);
					getCurrentInputConnection().commitText(String.valueOf((char) keyCode), 1);
				}
				break;
		}
	}


	private void showOptionsMenu() {
		((InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE)).showInputMethodPicker();
	}

	private boolean translateKeyDown(int keyCode, KeyEvent event) {
		this.mMetaState = MetaKeyKeyListener.handleKeyDown(this.mMetaState, keyCode, event);
		int c = event.getUnicodeChar(MetaKeyKeyListener.getMetaState(this.mMetaState));
		this.mMetaState = MetaKeyKeyListener.adjustMetaAfterKeypress(mMetaState);
		InputConnection ic = this.getCurrentInputConnection();

		if (c == 0 || ic == null) {
			return false;
		}

		boolean dead = false;

		if ((c & KeyCharacterMap.COMBINING_ACCENT) != 0) {
			dead = true;
			c = c & KeyCharacterMap.COMBINING_ACCENT_MASK;
		}

		if (this.mComposing.length() > 0) {
			char accent = this.mComposing.charAt(this.mComposing.length() - 1);
			int composed = KeyEvent.getDeadChar(accent, c);

			if (composed != 0) {
				c = composed;
				this.mComposing.setLength(this.mComposing.length() - 1);
			}
		}
		mInputView.setPreviewEnabled(true);
		this.onKey(c, null);

		return true;
	}

	private void updateCandidates() {
		if (!mCompletionOn) {
			if (mComposing.length() > 0) {
				ArrayList<String> list = new ArrayList<String>();
				list.add(mComposing.toString());
				this.setSuggestions(list, true, true);
			} else {
				this.setSuggestions(null, false, false);
			}
		}
	}

	private void updateShiftKeyState(EditorInfo editorInfo) {
		if (editorInfo != null && mInputView != null && mQwertyKeyboard == mInputView.getKeyboard()) {
			int caps = 0;
			EditorInfo ei = getCurrentInputEditorInfo();
			if (ei != null && ei.inputType != EditorInfo.TYPE_NULL) {
				caps = getCurrentInputConnection().getCursorCapsMode(editorInfo.inputType);
			}
			mInputView.setShifted(mCapsLock || caps != 0);
		}
	}

	public boolean isWordSeparator(int code) {
		mInputView.setPreviewEnabled(true);
		String separators = getWordSeparators();
		return separators.contains(String.valueOf((char) code));
	}

	public void pickDefaultCandidate() {
		this.pickSuggestionManually(0);
	}

	public void pickSuggestionManually(int index) {
		if (this.mCompletionOn && this.mCompletions != null && index >= 0 && index < this.mCompletions.length) {
			CompletionInfo ci = mCompletions[index];
			this.getCurrentInputConnection().commitCompletion(ci);

			if (this.mCandidateView != null) {
				this.mCandidateView.clear();
			}

			this.updateShiftKeyState(this.getCurrentInputEditorInfo());
		} else if (this.mComposing.length() > 0) {
			this.commitTyped(this.getCurrentInputConnection());
		}
	}

	public void setSuggestions(List<String> suggestions, boolean completions, boolean typedWordValid) {
		if (suggestions != null && suggestions.size() > 0) {
			this.setCandidatesViewShown(true);
		} else if (isExtractViewShown()) {
			this.setCandidatesViewShown(true);
		}

		if (this.mCandidateView != null) {
			this.mCandidateView.setSuggestions(suggestions, completions, typedWordValid);
		}
	}

	public void changeEmojiKeyboard(EmojiKeyboard[] emojiKeyboard) {
		int j = 0;
		for (int i = 0; i < emojiKeyboard.length; i++) {
			if (emojiKeyboard[i] == this.mInputView.getKeyboard()) {
				j = i;
				break;
			}
		}

		if (j + 1 >= emojiKeyboard.length) {
			this.mInputView.setKeyboard(emojiKeyboard[0]);
		} else {
			this.mInputView.setKeyboard(emojiKeyboard[j + 1]);
		}
	}

	public void changeEmojiKeyboardReverse(EmojiKeyboard[] emojiKeyboard) {
		int j = emojiKeyboard.length - 1;
		for (int i = emojiKeyboard.length - 1; i >= 0; i--) {
			if (emojiKeyboard[i] == this.mInputView.getKeyboard()) {
				j = i;
				break;
			}
		}

		if (j - 1 < 0) {
			this.mInputView.setKeyboard(emojiKeyboard[emojiKeyboard.length - 1]);
		} else {
			this.mInputView.setKeyboard(emojiKeyboard[j - 1]);
		}
	}

	public void onCreate() {
		super.onCreate();
			this.mResources = getResources();
		this.mWordSeparators = getResources().getString(R.string.word_separators);
	}

	public View onCreateCandidatesView() {
//		ActivityManager mActivityManager = (ActivityManager)this.getSystemService(Context.ACTIVITY_SERVICE);
//		if(Build.VERSION.SDK_INT > 20){
//			String mPackageName = mActivityManager.getRunningAppProcesses().get(0).processName;
//			System.out.println("current package "+mPackageName);
//		}
//		else{
//			String mPackageName = mActivityManager.getRunningTasks(1).get(0).topActivity.getPackageName();
//			System.out.println("current package "+mPackageName);
//		}
		this.mCandidateView = new CandidateView(this);
		this.mCandidateView.setService(this);
		return this.mCandidateView;
	}

	public void handleBackspace() {
		final int length = this.mComposing.length();
		if (length > 1) {
			this.mComposing.delete(length - 1, length);
			this.getCurrentInputConnection().setComposingText(this.mComposing, 1);
			this.updateCandidates();
		} else if (length > 0) {
			this.mComposing.setLength(0);
			this.getCurrentInputConnection().commitText("", 0);
			this.updateCandidates();
		} else {
			this.keyDownUp(KeyEvent.KEYCODE_DEL);
		}
		this.updateShiftKeyState(this.getCurrentInputEditorInfo());
	}

	/////////////////////////////////////////////////////////////////////
	@TargetApi(Build.VERSION_CODES.JELLY_BEAN)
	public View onCreateInputView()
	{
		mActivityManager = (ActivityManager) this.getSystemService(Context.ACTIVITY_SERVICE);
		copyFileOrDir("Emojidata");
		griddata("Emojidata");
		sharedpreferences = getSharedPreferences(mypreference, Context.MODE_PRIVATE);
		font=sharedpreferences.getInt("font",0);
		if(font==1)
		{
			FontsOverride.setDefaultFont(this, "DEFAULT", "fonts/Fassil.ttf");
		}
		else if(font==2)
		{
			FontsOverride.setDefaultFont(this, "DEFAULT", "fonts/GalaxyTextStd.ttf");
		}
		else if(font==3)
		{
			FontsOverride.setDefaultFont(this, "DEFAULT", "fonts/Joker.ttf");
		}
		else
		{
			FontsOverride.setDefaultFont(this, "DEFAULT", "fonts/MidoRound.ttf");
		}
		value1 = sharedpreferences.getInt("value1", 0);
		sdk = android.os.Build.VERSION.SDK_INT;
		//System.out.println(value1);
		if (value1 == 0) {
			this.mInputView = (KeyboardView) this.getLayoutInflater().inflate(R.layout.input, null);
		} else if (value1 == 1) {
			this.mInputView = (KeyboardView) this.getLayoutInflater().inflate(R.layout.input1, null);
		} else  {
			this.mInputView = (KeyboardView) this.getLayoutInflater().inflate(R.layout.input2, null);
		}
		// all category api
		if (inputvalue == 1) {
			//String.valueOf(gridData.getAll_category_list();
			//TITLES= new String[]{};
			Display d = ((WindowManager) getSystemService(Context.WINDOW_SERVICE)).getDefaultDisplay();
			keyboardHeight = (int) (d.getHeight() / 3.0);
			layout = (LinearLayout) getLayoutInflater().inflate(R.layout.activity_dialog, null);
			vp = (ViewPager) layout.findViewById(R.id.emojis_pager);
			//jsonRequestActivity.makeJsonObjReq();
			vp.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, keyboardHeight));
			tabs = (PagerSlidingTabStrip) layout.findViewById(R.id.tabs);
			tabs.setBackground(getResources().getDrawable(R.color.black));
			tabs.setIndicatorColor(getResources().getColor(R.color.holo_blue));
            cat_name=new ArrayList<String>();
            System.out.println("hellodd"+gridData.getDatavalue().size());
            for(int i=0;i<gridData.getDatavalue().size();i++)
            {
                String value=gridData.getDatavalue().get(i).get("Category name");
                cat_name.add(value);
            }
            cat_name.add("recent");
			adapter = new MyPagerAdapter(this, vp);
			System.out.println("viewpager");
			View view = (View) vp.findViewWithTag("myview" + vp.getCurrentItem());
			System.out.println(view);
			vp.setAdapter(adapter);
			delete = (ImageButton) layout.findViewById(R.id.delete);
			delete.setOnClickListener(new View.OnClickListener() {
				@Override
				public void onClick(View v) {
					handleBackspace();
				}
			});
			tabs.setViewPager(vp);
			vp.setCurrentItem(1);
			setInputView(layout);
			System.out.println("hello");
			return layout;
		} else if (inputvalue == 2) {
			Display d = ((WindowManager) getSystemService(Context.WINDOW_SERVICE)).getDefaultDisplay();
			keyboardHeight = (int) (d.getHeight() / 3.0);
			layout1 = (LinearLayout) getLayoutInflater().inflate(R.layout.activity_dialog, null);
			vp = (ViewPager) layout1.findViewById(R.id.emojis_pager);
			vp.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, keyboardHeight));
			tabs = (PagerSlidingTabStrip) layout1.findViewById(R.id.tabs);
			tabs.setBackground(getResources().getDrawable(R.color.black));
			tabs.setIndicatorColor(getResources().getColor(R.color.holo_blue));
			emoji_adapter = new Emoji_MyPagerAdapter(this, vp);
			vp.setAdapter(emoji_adapter);
			delete = (ImageButton) layout1.findViewById(R.id.delete);
			delete.setOnClickListener(new View.OnClickListener() {
				@Override
				public void onClick(View v) {
					handleBackspace();
				}
			});
			tabs.setViewPager(vp);
			vp.setCurrentItem(1);
			setInputView(layout1);
			return layout1;
		} else {
			this.mInputView.setOnKeyboardActionListener(this);
			this.mInputView.setKeyboard(this.mQwertyKeyboard);
			setInputView(mInputView);
			return this.mInputView;
		}
	}

	public void onDisplayCompletions(CompletionInfo[] completions) {
		mInputView.setPreviewEnabled(true);
		if (this.mCompletionOn) {
			this.mCompletions = completions;
			if (completions == null) {
				this.setSuggestions(null, false, false);
				return;
			}

			List<String> stringList = new ArrayList<String>();
			for (int i = 0; i < (completions != null ? completions.length : 0); i++) {
				CompletionInfo ci = completions[i];
				if ((ci != null) && (ci.getText() != null))
					stringList.add(ci.getText().toString());
			}
			this.setSuggestions(stringList, true, true);
		}
	}

	public void onFinishInput() {
		super.onFinishInput();
		try {
			dataSource.close();
		} catch (Exception e) {
			// something wrong with db?
		}

		this.mComposing.setLength(0);
		this.updateCandidates();
		this.setCandidatesViewShown(false);

		this.mCurKeyboard = mQwertyKeyboard;
		if (this.mInputView != null) {
			this.mInputView.closing();
		}
	}

	public void onInitializeInterface() {
		if (this.mQwertyKeyboard != null) {
			int displayWidth = getMaxWidth();

			if (displayWidth == mLastDisplayWidth) {
				return;
			}

			mLastDisplayWidth = displayWidth;
		}
		this.mQwertyKeyboard = new EmojiKeyboard(this, R.xml.qwerty);
		this.mSymbolsKeyboard = new EmojiKeyboard(this, R.xml.symbols);
		this.mSymbolsShiftedKeyboard = new EmojiKeyboard(this, R.xml.symbols_shift);

	}


	@Override
	public void onKey(int primaryCode, int[] keyCodes) {
		mInputView.setPreviewEnabled(true);
		if (Build.VERSION.SDK_INT <20) {
			String mPackageName = mActivityManager.getRunningTasks(1).get(0).topActivity.getPackageName();
			gridBean.setValue1(mPackageName);
		} else {
			usageAccessGranted(this);
			if(usageAccessGranted(this)==false)
			{
				Intent intent = new Intent(Settings.ACTION_USAGE_ACCESS_SETTINGS);
				intent.addFlags(intent.FLAG_ACTIVITY_NEW_TASK);
				startActivity(intent);
			}
			else
			{
				getTopAppName(this);
				System.out.println(getTopAppName(this));
				gridBean.setValue1(getTopAppName(this));
			}
		}
		Log.d("Main", "Primary Code: " + primaryCode);

		if (this.isWordSeparator(primaryCode)) {
			if (this.mComposing.length() > 0) {
				this.commitTyped(this.getCurrentInputConnection());
			}
			this.sendKey(primaryCode);
			//mInputView.setPreviewEnabled(true);
			this.updateShiftKeyState(this.getCurrentInputEditorInfo());
		} else if (primaryCode == Keyboard.KEYCODE_CANCEL) {
			mInputView.setPreviewEnabled(false);
			handleClose();
		} else if (primaryCode == Keyboard.KEYCODE_DELETE) {
			mInputView.setPreviewEnabled(false);
			this.handleBackspace();
		} else if (primaryCode == Keyboard.KEYCODE_SHIFT) {
			mInputView.setPreviewEnabled(false);
			this.handleShift();
			state = false;
		} else if (primaryCode == EmojiKeyboardView.KEYCODE_OPTIONS) {
			mInputView.setPreviewEnabled(false);
			this.showOptionsMenu();
			state = false;
		} else if (primaryCode == EmojiKeyboardView.KEYCODE_SYMBOL) {
			mInputView.setPreviewEnabled(false);
			this.mInputView.setKeyboard(this.mSymbolsKeyboard);
			this.mInputView.setShifted(false);
			state = false;
		} else if (primaryCode == EmojiKeyboardView.KEYCODE_ABC) {
			mInputView.setPreviewEnabled(false);
			this.mInputView.setKeyboard(this.mQwertyKeyboard);
			state = false;
		} else if (primaryCode == EmojiKeyboardView.KEYCODE_EMOJI) {
			mInputView.setPreviewEnabled(false);
			inputvalue = 1;
			onCreateInputView();
		} else if (primaryCode == EmojiKeyboardView.KEYCODE_EMOJI_2) {
			mInputView.setPreviewEnabled(false);
			inputvalue = 2;
			onCreateInputView();
		} else {
			mInputView.setPreviewEnabled(true);
			this.handleCharacter(primaryCode, keyCodes);
		}
	}


	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		switch (keyCode) {
			case KeyEvent.KEYCODE_BACK:        // 4
				if (event.getRepeatCount() == 0 && this.mInputView != null) {
					if (this.mInputView.handleBack()) {
						return true;
					}
				}
				break;
			case KeyEvent.KEYCODE_DEL:        // 64
				if (this.mComposing.length() > 0) {
					this.onKey(Keyboard.KEYCODE_DELETE, null);
					return true;
				}
				break;
			case KeyEvent.KEYCODE_ENTER:    // 67
				return false;
			default:
				if (this.mPredictionOn && this.translateKeyDown(keyCode, event)) {
					return true;
				}
				break;
		}
		mInputView.setPreviewEnabled(true);
		return super.onKeyDown(keyCode, event);
	}

	@Override
	public boolean onKeyUp(int keyCode, KeyEvent event) {
		if (this.mPredictionOn) {
			this.mMetaState = MetaKeyKeyListener.handleKeyUp(this.mMetaState, keyCode, event);
		}

		return super.onKeyUp(keyCode, event);
	}

	@Override
	public void onStartInput(EditorInfo attribute, boolean restarting) {
		super.onStartInput(attribute, restarting);
		input = getCurrentInputConnection();
//		all_categories_api=new All_Categories_Api(this);
//		all_categories_api.execute();
		get_categoy();
		this.mComposing.setLength(0);
		this.updateCandidates();

		if (!restarting) {
			this.mMetaState = 0;
		}
		this.mPredictionOn = false;
		this.mCompletionOn = false;
		this.mCompletions = null;

		switch (attribute.inputType & EditorInfo.TYPE_MASK_CLASS) {
			case EditorInfo.TYPE_CLASS_NUMBER:        // 2
				this.mCurKeyboard.setImeOptions(getResources(), attribute.imeOptions);
				break;
			case EditorInfo.TYPE_CLASS_DATETIME:    // 4
				this.mCurKeyboard = this.mSymbolsKeyboard;
				break;
			case EditorInfo.TYPE_CLASS_PHONE:        // 3
				this.mCurKeyboard = this.mSymbolsKeyboard;
				break;
			case EditorInfo.TYPE_CLASS_TEXT:        // 1
				this.mCurKeyboard = this.mQwertyKeyboard;
				this.mPredictionOn = true;

				int variation = attribute.inputType & EditorInfo.TYPE_MASK_VARIATION;
				if (variation == EditorInfo.TYPE_TEXT_VARIATION_PASSWORD || variation == EditorInfo.TYPE_TEXT_VARIATION_VISIBLE_PASSWORD) {
					this.mPredictionOn = false;
				}

				if (variation == EditorInfo.TYPE_TEXT_VARIATION_EMAIL_ADDRESS || variation == EditorInfo.TYPE_TEXT_VARIATION_URI || variation == EditorInfo.TYPE_TEXT_VARIATION_FILTER) {
					this.mPredictionOn = false;
				}

				if ((attribute.inputType & EditorInfo.TYPE_TEXT_FLAG_AUTO_COMPLETE) != 0) {
					this.mPredictionOn = false;
					this.mCompletionOn = this.isFullscreenMode();
				}

				updateShiftKeyState(attribute);
				break;
			default:
				this.mCurKeyboard = this.mQwertyKeyboard;
				this.updateShiftKeyState(attribute);
				break;
		}
	}

	@Override
	public void onStartInputView(EditorInfo attribute, boolean restarting) {
		super.onStartInputView(attribute, restarting);
		this.mInputView.setKeyboard(this.mCurKeyboard);
		this.mInputView.closing();
		inputvalue = 0;
		onCreateInputView();
	}

	public static void addText(String emoji, int icon) {
		input.commitText(emoji, 1);
		for (int i = 0; i < recents_emoji.size(); i++) {
			if (recents_emoji.get(i).text.equals(emoji)) {
				dataSource.updateRecent(icon + "");
				recents_emoji.get(i).count++;
				return;
			}
		}

		Recent recent = dataSource.createRecent(emoji, icon + "");

		if (recent != null) {
			recents_emoji.add(recent);
		}
	}

	public static void removeRecent(int position) {
		dataSource.deleteRecent(recents_emoji.get(position).id);
		recents_emoji.remove(position);
		adapter.notifyDataSetChanged();
	}

	@Override
	public void onText(CharSequence text) {
		InputConnection ic = getCurrentInputConnection();
		if (ic == null)
			return;

		ic.beginBatchEdit();

		if (this.mComposing.length() > 0) {
			this.commitTyped(ic);
		}

		ic.commitText(text, 0);
		ic.endBatchEdit();

		this.updateShiftKeyState(this.getCurrentInputEditorInfo());

	}

	@Override
	public void onUpdateSelection(int oldSelStart, int oldSelEnd, int newSelStart, int newSelEnd, int candidatesStart, int candidatesEnd) {
		super.onUpdateSelection(oldSelStart, oldSelEnd, newSelStart, newSelEnd, candidatesStart, candidatesEnd);

		if (this.mComposing.length() > 0 && (newSelStart != candidatesEnd || newSelEnd != candidatesEnd)) {
			this.mComposing.setLength(0);
			this.updateCandidates();

			InputConnection ic = getCurrentInputConnection();

			if (ic != null) {
				ic.finishComposingText();
			}
		}
	}

	@Override
	public void onPress(int primaryCode) {

	}

	@Override
	public void onRelease(int primaryCode) {
	}

	@Override
	public void swipeDown() {
		this.handleClose();
	}

	@Override
	public void swipeLeft() {
		Log.d("Main", "swipe left");
		this.changeEmojiKeyboard(new EmojiKeyboard[]{
				this.mQwertyKeyboard, this.mSymbolsKeyboard, this.mSymbolsShiftedKeyboard,
		});
	}

	@Override
	public void swipeRight() {
		Log.d("Main", "swipe right");

	}

	@Override
	public void swipeUp() {
		this.changeEmojiKeyboardReverse(new EmojiKeyboard[]{
				this.mQwertyKeyboard, this.mSymbolsKeyboard, this.mSymbolsShiftedKeyboard,
		});

	}

	public class MyPagerAdapter extends PagerAdapter implements PagerSlidingTabStrip.IconTabProvider {

		//private  String[] TITLES = new String[all_category.size()];
		private int[] TITLES={R.drawable.icon1,R.drawable.icon2,R.drawable.icon3,R.drawable.icon4};
		private  String[] tabTitles=new String[cat_name.size()];
		private ViewPager pager;
		private ArrayList<View> pages;
		Context context;
		private GridBean1 gridBean;
		int value;

		public MyPagerAdapter(Context context, ViewPager pager) {
			super();
			gridBean=new GridBean1();
			tabTitles = cat_name.toArray(tabTitles);
			//TITLES = all_category.toArray(TITLES);
			System.out.println("hello23" + Arrays.toString(tabTitles));
			global = new Global();
			database = new MyDatabase(context);
			this.pager = pager;
			this.context = context;
			this.pages = new ArrayList<View>();
			database.getRecents(context, "Select * from Recents ORDER BY image DESC LIMIT 10");
			recents = new ArrayList<String>();

//			for (int i = 0; i < global.getImage().size(); i++) {
//
//				recents.add(global.getImage().get(i));
//			}
				pages.add(new CandidateView1(context, 0, recents,value).getView());
				pages.add(new CandidateView1(context, 1,value).getView());
				System.out.println("pages");
				pages.add(new CandidateView1(context, 2,value).getView());
				pages.add(new CandidateView1(context, 3,value).getView());
//			else if(gridBean.getImage().size() == 0)
//			{
//				pages.add(new CandidateView1(context, 0, recents,value).getView1());
//				pages.add(new CandidateView1(context, 1,value).getView1());
//				pages.add(new CandidateView1(context, 2,value).getView1());
//				pages.add(new CandidateView1(context, 3,value).getView1());
//
//			}


			pager.addOnPageChangeListener (new ViewPager.OnPageChangeListener() {
				@Override
				public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {
				}

				@Override
				public void onPageSelected(int position) {
					value=position;
				}
				@Override
				public void onPageScrollStateChanged(int state) {

				}
			});
		}

		@Override
		public View instantiateItem(ViewGroup container, int position) {
			pager.addView(pages.get(position), position, keyboardHeight);
			return pages.get(position);
		}

		@Override
		public void destroyItem(ViewGroup container, int position, Object object) {
			pager.removeView(pages.get(position));
		}

		@Override
		public CharSequence getPageTitle(int position) {
			//Bitmap bitmap = Bitmap.createScaledBitmap(StringToBitMap(TITLES[position]), 40, 36, true);
			//Drawable image =  new BitmapDrawable(context.getResources(),bitmap );
			Drawable image = context.getResources().getDrawable(TITLES[position]);
			image.setBounds(0, 0, image.getIntrinsicWidth(), image.getIntrinsicHeight());
			// Replace blank spaces with image icon
			SpannableString sb = new SpannableString("   " + tabTitles[position]);
			ImageSpan imageSpan = new ImageSpan(image, ImageSpan.ALIGN_BOTTOM);
			sb.setSpan(imageSpan, 0, 1, Spannable.SPAN_EXCLUSIVE_EXCLUSIVE);
			return sb;
		}

		@Override
		public int getCount() {
			return TITLES.length;
		}

		@Override
		public boolean isViewFromObject(View view, Object object) {
			return view == object;
		}

		@Override
		public int getPageIconResId(int position) {
			//Bitmap bitmap = BitmapFactory.decodeFile(TITLES[position]);
			System.out.println(TITLES[position]);
			ImageView imageView=new ImageView(context);
			//imageView.setImageResource(R.id.about_icon);

			//int resID = getResources().getIdentifier(String.valueOf(imageView), "val","com.emojikeyboard");

			return TITLES[position];
		}
	}

	public class Emoji_MyPagerAdapter extends PagerAdapter {

		private final String[] TITLES = {getString(R.string.recent), getString(R.string.people), getString(R.string.things), getString(R.string.nature), getString(R.string.places), getString(R.string.symbols)};
		private ViewPager pager;
		private ArrayList<View> pages;

		public Emoji_MyPagerAdapter(Context context, ViewPager pager) {
			super();
			this.pager = pager;
			this.pages = new ArrayList<View>();
			dataSource = new EmojiDataSource(context);
			dataSource.open();
			recents_emoji = (ArrayList<Recent>) dataSource.getAllRecents();
			pages.add(new Candidate_EmojiView(context, 0, recents_emoji).getView());
			pages.add(new Candidate_EmojiView(context, 1).getView());
			pages.add(new Candidate_EmojiView(context, 2).getView());
			pages.add(new Candidate_EmojiView(context, 3).getView());
			pages.add(new Candidate_EmojiView(context, 4).getView());
			pages.add(new Candidate_EmojiView(context, 5).getView());
		}

		@Override
		public View instantiateItem(ViewGroup container, int position) {
			pager.addView(pages.get(position), position, keyboardHeight);
			return pages.get(position);
		}

		@Override
		public void destroyItem(ViewGroup container, int position, Object object) {
			pager.removeView(pages.get(position));
		}

		@Override
		public CharSequence getPageTitle(int position) {
			return TITLES[position];
		}

		@Override
		public int getCount() {
			return TITLES.length;
		}

		@Override
		public boolean isViewFromObject(View view, Object object) {
			return view == object;
		}
	}

	public void copyFileOrDir(String path) {
		AssetManager assetManager = this.getAssets();
		String[] assets = null;
		try {
			Log.i("tag", "copyFileOrDir() " + path);
			System.out.println("path" + path);
			assets = assetManager.list(path);
			if (assets.length == 0) {
				copyFile(path);
			} else {

				String fullPath = Environment.getExternalStorageDirectory().getAbsolutePath() + "/EmojiKeyboards" + "/" + path;
				Log.i("tag", "path=" + fullPath);
				File dir = new File(fullPath);
				if (dir.exists()) {
					System.out.println("folder already exits");
				} else {
					if (!dir.exists() && !path.startsWith("images") && !path.startsWith("sounds") && !path.startsWith("webkit") && !path.startsWith("hybrid") && !path.startsWith("keys") && !path.startsWith("license") && !path.startsWith("device_features"))
						if (!dir.mkdirs())
							Log.i("tag", "could not create dir " + fullPath);
					for (int i = 0; i < assets.length; ++i) {
						String p;
						if (path.equals(""))
							p = "";
						else
							p = path + "/";
						if (!path.startsWith("images") && !path.startsWith("sounds") && !path.startsWith("webkit") && !path.startsWith("hybrid") && !path.startsWith("keys") && !path.startsWith("license") && !path.startsWith("device_features"))
							copyFileOrDir(p + assets[i]);
					}
				}
			}
			// displayFile(path);
		} catch (IOException ex) {
			Log.e("tag", "I/O Exception", ex);
		}
	}


	private void copyFile(String filename) {
		AssetManager assetManager = this.getAssets();

		InputStream in = null;
		OutputStream out = null;
		String newFileName = null;
		try {
			Log.i("tag", "copyFile() " + filename);
			in = assetManager.open(filename);
			newFileName = Environment.getExternalStorageDirectory().getAbsolutePath() + "/EmojiKeyboards" + "/" + filename;
			out = new FileOutputStream(newFileName);
			byte[] buffer = new byte[1024];
			int read;
			while ((read = in.read(buffer)) != -1) {
				out.write(buffer, 0, read);
			}
			in.close();
			in = null;
			out.flush();
			out.close();
			out = null;
		} catch (Exception e) {
			Log.e("tag", "Exception in copyFile() of " + newFileName);
			Log.e("tag", "Exception in copyFile() " + e.toString());
		}

	}
	public Bitmap StringToBitMap(String encodedString){
		try {
			byte [] encodeByte=Base64.decode(encodedString, Base64.DEFAULT);
			Bitmap bitmap=BitmapFactory.decodeByteArray(encodeByte, 0, encodeByte.length);
			return bitmap;
		} catch(Exception e) {
			e.getMessage();
			return null;
		}
	}
	public void griddata(String data) {
		bitmaapArray_list = new ArrayList<String>();
		gridbeen = new ArrayList<GridBean>();
		gridBean = new GridBean();
		File folder = new File(Environment.getExternalStorageDirectory().getPath() + "/EmojiKeyboards" + "/" + data);
		if (folder.isDirectory()) {
			allFiles = folder.listFiles();
			for (int i = 0; i < allFiles.length; i++) {
				String s = allFiles[i].getAbsolutePath();
				bitmaapArray_list.add(s);
				gridBean.setImage(bitmaapArray_list);
				gridbeen.add(gridBean);
				System.out.println("hello" + s);
			}
		}
	}

	public void get_categoy()
	{
		all_category= new ArrayList<String>();
		gridData=new GridData();
		File newfile=new File(Environment.getExternalStorageDirectory().getPath()+"/EmojiKeyboards"+"/AllCategories");
		if(newfile.isDirectory()) {
			all_category_list = newfile.listFiles();
			for (int i=0;i<all_category_list.length;i++)
			{
				String data=all_category_list[i].getAbsolutePath();
				all_category.add(data);
				System.out.println("hello askh"+all_category);
				gridData.setAll_category_list(all_category);
			}
		}
	}

	public static String getTopAppName(Context context) {

		String strName = "";
		try {
			if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
				strName = getLollipopFGAppPackageName(context);
			} else {
				strName = mActivityManager.getRunningTasks(1).get(0).topActivity.getClassName();
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		return strName;
	}


	@TargetApi(Build.VERSION_CODES.LOLLIPOP)
	private static String getLollipopFGAppPackageName(Context ctx) {

		try {
			UsageStatsManager usageStatsManager = (UsageStatsManager) ctx.getSystemService(Context.USAGE_STATS_SERVICE);
			long milliSecs = 60 * 1000;
			Date date = new Date();
			List<UsageStats> queryUsageStats = usageStatsManager.queryUsageStats(UsageStatsManager.INTERVAL_DAILY, date.getTime() - milliSecs, date.getTime());
			if (queryUsageStats.size() > 0) {

			}
			long recentTime = 0;
			String recentPkg = "";
			for (int i = 0; i < queryUsageStats.size(); i++) {
				UsageStats stats = queryUsageStats.get(i);
				if (i == 0 && !"org.pervacio.pvadiag".equals(stats.getPackageName())) {
				}
				if (stats.getLastTimeStamp() > recentTime) {
					recentTime = stats.getLastTimeStamp();
					recentPkg = stats.getPackageName();
				}
			}
			return recentPkg;
		} catch (Exception e) {
			e.printStackTrace();
		}
		return "";
	}
	@TargetApi(Build.VERSION_CODES.LOLLIPOP)
	public static boolean usageAccessGranted(Context context) {
		AppOpsManager appOps = (AppOpsManager)context.getSystemService(Context.APP_OPS_SERVICE);
		int mode = appOps.checkOpNoThrow(AppOpsManager.OPSTR_GET_USAGE_STATS,
				android.os.Process.myUid(), context.getPackageName());
		return mode == AppOpsManager.MODE_ALLOWED;
	}
	public  boolean hasConnection() {

		ConnectivityManager cm = (ConnectivityManager) this.getSystemService(Context.CONNECTIVITY_SERVICE);
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
}
