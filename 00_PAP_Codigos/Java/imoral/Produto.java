 
public abstract class Produto
{
    private int id;
    private String nome;
    private String tipo;
    private String cor;
    private String tamanho;
    private int imagemId;
    private int stock;
    private double peso;
    private double precoVenda;
    private double precoCusto;
    public Produto(int id, String nome, String tipo, String cor, String tamanho, int imagemId, int stock, double peso, double precoVenda, double precoCusto)
    {
        this.id = id;
        this.nome = nome;
        this.tipo = tipo;
        this.cor = cor;
        this.tamanho = tamanho;
        this.imagemId = imagemId;
        this.stock = stock;
        this.peso = peso;
        this.precoVenda = precoVenda;
        this.precoCusto = precoCusto;
    }
    
    public String getNome()
    {
        return this.nome;
    }
    
    public void setNome(String nome)
    {
        this.nome = nome;
    }
    
    public String getTipo()
    {
        return this.tipo;
    }
    
    public String getCor()
    {
        return this.cor;
    }
    
    public String getTamanho()
    {
        return this.tamanho;
    }

    public int getImagemId(){return this.imagemId;}
    
    public int getStock()
    {
        return this.stock;
    }
    
    public void setStock(int stock)
    {
        this.stock = stock;
    }
    
    public double getPeso()
    {
        return this.peso;
    }
    
    public double getPrecoVenda()
    {
        return this.precoVenda;
    }
    
    public void setPrecoVenda(double precoVenda)
    {
        this.precoVenda = precoVenda;
    }
    
     public double getPrecoCusto()
    {
        return this.precoCusto;
    }
    
    public void setPrecoCusto(double precoCusto)
    {
        this.precoCusto = precoCusto;
    }
}
