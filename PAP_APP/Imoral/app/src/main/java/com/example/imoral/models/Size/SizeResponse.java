package com.example.imoral.models.Size;

import com.example.imoral.models.Size.SizeData;
public class SizeResponse {
    private boolean success;
    private String message;
    private SizeData data;

    public boolean isSuccess() {
        return success;
    }

    public String getMessage() {
        return message;
    }

    public SizeData getData() {
        return data;
    }
}
