package com.example.imoral.models.Forum;

import com.example.imoral.models.Forum.ForumData;

public class ForumResponse {
    private boolean success;
    private String message;
    private ForumData data;

    public boolean isSuccess() {
        return success;
    }

    public String getMessage() {
        return message;
    }

    public ForumData getData() {
        return data;
    }
}
