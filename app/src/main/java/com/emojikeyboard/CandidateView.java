package com.emojikeyboard;

import android.content.Context;
import android.content.SharedPreferences;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.graphics.Rect;
import android.graphics.Typeface;
import android.graphics.drawable.Drawable;
import android.inputmethodservice.Keyboard;
import android.view.GestureDetector;
import android.view.GestureDetector.SimpleOnGestureListener;
import android.view.MotionEvent;
import android.view.View;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

public class CandidateView extends View {

	private int[] mWordWidth;
	private int[] mWordX;
	private int value;
	private Drawable mSelectionHighlight;


	
	private int mVerticalPadding;
	
	private Paint mPaint;
	
	private GestureDetector mGestureDetector;
	
	private int mTouchX = -1;
	
	private int mTargetScrollX;
	
	private static final List<String> EMPTY_LIST = new ArrayList<String>();

	private int mSelectedIndex;

	private int mTotalWidth;
	
	private SoftKeyboard mService;
	
	private boolean mTypedWordValid;
	
	private boolean mScrolled;
	
	private Rect mBgPadding;
	Context context;
	SharedPreferences sharedpreferences;
	String mypreference = "mypref";
	int value1;
	
	public CandidateView(Context context) {
		super(context);

		this.mWordWidth = new int[32];
		this.mWordX = new int[32];

		this.mSelectionHighlight = context.getResources().getDrawable(R.drawable.sym_keyboard_return);
		this.mSelectionHighlight.setState(new int[] {
			android.R.attr.state_enabled,
			android.R.attr.state_focused,
			android.R.attr.state_window_focused,
			android.R.attr.state_pressed,
		});

		this.mVerticalPadding = context.getResources().getDimensionPixelSize(R.dimen.candidate_vertical_padding);

		this.mPaint = new Paint();

		this.mPaint.setAntiAlias(true);
		this.mPaint.setTextSize(context.getResources().getDimensionPixelSize(R.dimen.candidate_font_height));
		this.mPaint.setStrokeWidth(0.0f);
		
		this.mGestureDetector = new GestureDetector(new SimpleOnGestureListener() {
			@Override
			public boolean onScroll(MotionEvent e1, MotionEvent e2, float distanceX, float distanceY) {
				mScrolled = true;
				
				int scrollX = getScrollX();
				
				scrollX += distanceX;
				if (scrollX < 0) {
					scrollX = 0;
				}
				if (scrollX + getWidth() > mTotalWidth) {
					scrollX -= distanceX;
				}
				
				mTargetScrollX = scrollX;
				scrollTo(scrollX, getScrollY());
				invalidate();
				
				return true;
			}
		});
		
		this.setHorizontalFadingEdgeEnabled(true);
		this.setWillNotDraw(false);
		this.setHorizontalScrollBarEnabled(false);
		this.setVerticalScrollBarEnabled(false);
	}

	private void removeHighlight() {
		this.mTouchX = -1;
		this.invalidate();
	}
	
	private void scrollToTarget() {
		int scrollX = this.getScrollX();
		
		if (this.mTargetScrollX > scrollX) {
			scrollX = scrollX + 20;
			
			if (scrollX >= this.mTargetScrollX) {
				scrollX = this.mTargetScrollX;
				this.requestLayout();
			}
		}else{
			scrollX = scrollX - 20;
			if (scrollX <= this.mTargetScrollX) {
				scrollX = this.mTargetScrollX;
				this.requestLayout();
			}
		}
		
		this.scrollTo(scrollX, getScrollY());
		this.invalidate();
	}
	
	public void clear() {

		this.mTouchX = -1;
		this.mSelectedIndex = -1;
		this.invalidate();
	}
	
	public int computeHorizontalScrollRange() {
		return this.mTotalWidth;
	}
	
	public void setService(SoftKeyboard softKeyboard) {
		this.mService = softKeyboard;
	}
	
	public void setSuggestions(List<String> suggestions, boolean completions, boolean typedWordValid) {
		clear();



		this.mTypedWordValid = typedWordValid;

		this.scrollTo(0, 0);
		mTargetScrollX = 0;

		this.invalidate();
		this.requestLayout();
	}
	
	public void takeSuggestionAt(float x) {
		this.mTouchX = (int) x;
		if (this.mSelectedIndex >= 0) {
			this.mService.pickSuggestionManually(this.mSelectedIndex);
		}
		
		this.invalidate();
	}

	@Override
	protected void onMeasure(int widthMeasureSpec, int heightMeasureSpec) {
		Rect rect = new Rect();
		this.mSelectionHighlight.getPadding(rect);
		this.setMeasuredDimension(
			resolveSize(50, widthMeasureSpec),
			resolveSize((int)this.mPaint.getTextSize() + this.mVerticalPadding + rect.top + rect.bottom, heightMeasureSpec)
		);
	}

	@Override
	public boolean onTouchEvent(MotionEvent event) {
		if (mGestureDetector.onTouchEvent(event)) {
            return true;
        }
		
		int action = event.getAction();
		int x = (int) event.getX();
		int y = (int) event.getY();
		
		this.mTouchX = x;
		
		switch (action) {
			case MotionEvent.ACTION_DOWN:	// 0
				this.mScrolled = false;
				this.invalidate();
				break;
			case MotionEvent.ACTION_MOVE:	// 2
				if (y <= 0 && this.mSelectedIndex >= 0) {
					this.mService.pickSuggestionManually(this.mSelectedIndex);
					this.mSelectedIndex = -1;
				}
				this.invalidate();
				break;
			case MotionEvent.ACTION_UP:		// 1
				if (!this.mScrolled && this.mSelectedIndex >= 0) {
					this.mService.pickSuggestionManually(this.mSelectedIndex);
                }
				this.mSelectedIndex = -1;
				this.removeHighlight();
				this.requestLayout();
				break;
		}
		
		return true;
	}

	@Override
	protected void onDraw(Canvas canvas) {
		if (canvas != null) {
			super.onDraw(canvas);
		}
		this.mTotalWidth = 0;
		//setTypeface(font);

		if (this.mBgPadding == null) {
			this.mBgPadding = new Rect(0, 0, 0, 0);
			if (this.getBackground() != null) {
				this.getBackground().getPadding(this.mBgPadding);
			}
		}

		int x = 0;
		final int height = this.getHeight();
		final Rect bgPadding = this.mBgPadding;
		final int touchX = this.mTouchX;
		final int scrollX = this.getScrollX();
		final boolean scrolled = this.mScrolled;
		final boolean typedWordValid = this.mTypedWordValid;
		final int y = (int) (((height - this.mPaint.getTextSize()) / 2) - this.mPaint.ascent());

	}

}
