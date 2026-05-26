package com.example.imoral.models;
public class Utilizador
{
    private int id;
    private String nome;
    private String email;
    private int imagemId;
    private String role;
    private String telefone;
    private String password;
    private String morada;
    private String dtNascimento;
    
    public Utilizador(int id, String nome, String email, int imagemId, String role, String telefone, String password, String morada, String dtNascimento )
    {
        this.id = id;
        this.nome = nome;
        this.email = email;
        this.imagemId = imagemId;
        this.role = role;
        this.telefone = telefone;
        this.password = password;
        this.morada = morada;
        this.dtNascimento = dtNascimento;
    }

    public int getId()
    {
        return this.id;
    }
    
    public String getUsername()
    {
        return this.nome;
    }
    
    public void setNome(String nome)
    {
        this.nome = nome;
    }
    
    public String getEmail()
    {
        return this.email;
    }
    
    public void setEmail(String email)
    {
        this.email = email;
    }
    
    public int getImagemId()
    {
        return this.imagemId;
    }
    
    public void setImagemId(int imagemId)
    {
        this.imagemId = imagemId;
    }
    
    public String getRole() 
    {
        return this.role;
    }
    
    public void setRole(String role)
    {
        this.role = role;
    }
    
    public String getTelefone()
    {
        return this.telefone;
    }
    
    public void setTelefone(String telefone)
    {
        this.telefone = telefone;
    }
    
    public String getPassword()
    {
        return this.password;
    }
    
    public void setPassword(String password)
    {
        this.password = password;
    }
    
    public String getMorada()
    {
        return this.morada;
    }
    
    public void setMorada(String password)
    {
        this.morada = morada;
    }
    
    public String getDtNascimento()
    {
        return this.dtNascimento;
    }
    
    public void setDtNascimento(String dt_nascimento)
    {
        this.dtNascimento = dtNascimento;
    }
}
