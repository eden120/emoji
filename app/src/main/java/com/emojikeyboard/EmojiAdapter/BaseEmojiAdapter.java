package com.emojikeyboard.EmojiAdapter;

import android.content.Context;
import android.widget.BaseAdapter;

public abstract class BaseEmojiAdapter extends BaseAdapter {

    protected Context context;

    public BaseEmojiAdapter(Context context) {
        this.context = context;
    }

    @Override
    public Object getItem(int arg0) {
        return null;
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }
}
