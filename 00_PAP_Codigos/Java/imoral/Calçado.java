 
public class Calçado extends Produto
{
    private static final String TIPO = "Calçado";
<<<<<<< HEAD
    public Calçado(int id, String nome, String cor, String tamanho, int stock, double peso, double precoVenda, double precoCusto)
    {
        super(id, nome, TIPO, cor, tamanho, stock, peso, precoVenda, precoCusto);
=======
    public Calçado(int id, String nome, String cor, String tamanho, int imagemId, int stock, double peso, double precoVenda, double precoCusto)
    {
        super(id, nome, TIPO, cor, tamanho, imagemId, stock, peso, precoVenda, precoCusto);
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
    }
}
