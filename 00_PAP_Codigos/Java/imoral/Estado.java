public class Estado
{
    // tornar tudo final?
    private int id;
    private String nome; // Ex: Entregado
    private String descricao;
    private String cor;
    private boolean entregado;

    public Estado(int id, String nome, String descricao, String cor, boolean entregado)
    {
        this.id = id;
        this.nome = nome;
        this.descricao = descricao;
        this.cor = cor;
        this.entregado = entregado;
    }
    
    public String getNome()
    {
        return this.nome;
    }
    
    public String getDescricao()
    {
        return this.descricao;
    }
  
    public String getCor()
    {
        return this.cor;
    }
    
    public boolean getEntregado()
    {
        return this.entregado;
    }
}
