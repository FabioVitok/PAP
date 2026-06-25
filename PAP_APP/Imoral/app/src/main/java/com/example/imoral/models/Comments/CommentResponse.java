package com.example.imoral.models.Comments;

import com.example.imoral.models.Comments.CommentData;

public class CommentResponse {
    private boolean success;
    private String message;
    private CommentData data;

    public boolean isSuccess() {
        return success;
    }

    public String getMessage() {
        return message;
    }

    public CommentData getData() {
        return data;
    }
}
