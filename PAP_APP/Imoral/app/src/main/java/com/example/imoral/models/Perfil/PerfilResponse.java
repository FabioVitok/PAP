package com.example.imoral.models.Perfil;

import com.example.imoral.models.Forum.ForumData;

public class PerfilResponse {
    private boolean success;
    private String message;
    private PerfilData data;

    public boolean isSuccess() {
        return success;
    }

    public String getMessage() {
        return message;
    }

    public PerfilData getData() {
        return data;
    }
}
