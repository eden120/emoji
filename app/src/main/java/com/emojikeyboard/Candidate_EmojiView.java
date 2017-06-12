package com.emojikeyboard;

import android.content.Context;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;
import android.util.Log;
import android.util.TypedValue;
import android.view.View;
import android.widget.GridView;

import com.emojikeyboard.EmojiAdapter.NatureEmojiAdapter;
import com.emojikeyboard.EmojiAdapter.OtherEmojiAdapter;
import com.emojikeyboard.EmojiAdapter.PeopleEmojiAdapter;
import com.emojikeyboard.EmojiAdapter.RecentEmojiAdapter;
import com.emojikeyboard.EmojiAdapter.ThingsEmojiAdapter;
import com.emojikeyboard.EmojiAdapter.TransEmojiAdapter;
import com.emojikeyboard.sqlite.Recent;

import java.util.ArrayList;

/**
 * Created by Ajit on 9/3/2016.
 */
public class Candidate_EmojiView {
        private int position,sdk;
        private Context context;
        private ArrayList<Recent> recents;

        public Candidate_EmojiView(Context context, int position) {
            this.context = context;
            this.position = position;
        }

        public Candidate_EmojiView(Context context, int position, ArrayList<Recent> recents) {
            this(context, position);
            this.recents = recents;
        }

        public View getView() {
            final GridView emojiGrid = new GridView(context);
            sdk = android.os.Build.VERSION.SDK_INT;
            if(sdk < android.os.Build.VERSION_CODES.JELLY_BEAN) {
                emojiGrid.setBackgroundDrawable( context.getResources().getDrawable(R.drawable.bg3) );
            } else {
                emojiGrid.setBackground( context.getResources().getDrawable(R.drawable.bg3));
            }
            emojiGrid.setColumnWidth((int) TypedValue.applyDimension(TypedValue.COMPLEX_UNIT_DIP, 50, context.getResources().getDisplayMetrics()));
            emojiGrid.setNumColumns(GridView.AUTO_FIT);

            if (position == 0) {
                for (int i = 0; i < SoftKeyboard.recents_emoji.size(); i++) {
                    Log.v("recent_emojis", SoftKeyboard.recents_emoji.get(i).id + " " + SoftKeyboard.recents_emoji.get(i).count);
                }
                emojiGrid.setAdapter(new RecentEmojiAdapter(context, recents));

            }
            else if (position == 1)
                emojiGrid.setAdapter(new PeopleEmojiAdapter(context));
            else if (position == 2)
                emojiGrid.setAdapter(new ThingsEmojiAdapter(context));
            else if (position == 3)
                emojiGrid.setAdapter(new NatureEmojiAdapter(context));
            else if (position == 4)
                emojiGrid.setAdapter(new TransEmojiAdapter(context));
            else
                emojiGrid.setAdapter(new OtherEmojiAdapter(context));

            return emojiGrid;
        }
}