package com.example.imoral.models;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;

public class Comentario implements Serializable {
    private int id;
    private int id_post;
    private int id_utilizador;
    private Integer id_comentario_pai;
    private String dt_comentario;
    private String texto_comentario;
    private int like_count;
    private int comment_count;
    private String username;
    private String image;
    private boolean mostrarRespostas = false;
    private List<Comentario> respostas = new ArrayList<>();

    public Comentario() {}

    public int getId() { return id; }
    public void setId(int id) { this.id = id; }

    public int getId_post() { return id_post; }
    public void setId_post(int id_post) { this.id_post = id_post; }

    public int getId_utilizador() { return id_utilizador; }
    public void setId_utilizador(int id_utilizador) { this.id_utilizador = id_utilizador; }

    public Integer getId_comentario_pai() { return id_comentario_pai; }
    public void setId_comentario_pai(Integer id_comentario_pai) { this.id_comentario_pai = id_comentario_pai; }

    public String getDt_comentario() { return dt_comentario; }
    public void setDt_comentario(String dt_comentario) { this.dt_comentario = dt_comentario; }

    public String getTexto_comentario() { return texto_comentario; }
    public void setTexto_comentario(String texto_comentario) { this.texto_comentario = texto_comentario; }

    public int getLike_count() { return like_count; }
    public void setLike_count(int like_count) { this.like_count = like_count; }

    public int getComment_count() { return comment_count; }
    public void setComment_count(int comment_count) { this.comment_count = comment_count; }

    public String getUsername() { return username; }
    public void setUsername(String username) { this.username = username; }

    public String getImage() { return image; }
    public void setImage(String image) { this.image = image; }

    public boolean isMostrarRespostas() { return mostrarRespostas; }
    public void setMostrarRespostas(boolean mostrarRespostas) { this.mostrarRespostas = mostrarRespostas; }

    public List<Comentario> getRespostas() { return respostas; }
    public void setRespostas(List<Comentario> respostas) { this.respostas = respostas; }
}



