package com.example.imoral.models.Home;

import com.example.imoral.models.Home.HomeData;

public class HomeResponse {
    private boolean success;
    private String message;
    private HomeData data;

    public boolean isSuccess() {
        return success;
    }

    public String getMessage() {
        return message;
    }

    public HomeData getData() {
        return data;
    }
}

