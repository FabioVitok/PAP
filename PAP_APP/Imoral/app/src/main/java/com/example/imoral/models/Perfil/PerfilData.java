package com.example.imoral.models.Perfil;

import com.example.imoral.models.Post;
import com.example.imoral.models.Utilizador;

import java.util.List;

public class PerfilData {
    private List<Post> posts;
    private Utilizador user;

    public List<Post> getPosts() {
        return posts;
    }

    public Utilizador getUser() {
        return user;
    }
}
