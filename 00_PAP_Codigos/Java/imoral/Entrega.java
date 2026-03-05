public class Entrega
{
    private int id;
    private Pedido pedido;
    private String morada;
    private String metodoEnvio;
    private String entregadora;
    private double peso;
    private String dataEntrega;
    private Estado estadoEntrega;
    
    public Entrega(int id, Pedido pedido, String morada, String metodoEnvio, String entregadora, Estado estadoEntrega)
    {
        this.id = id;
        this.pedido = pedido;
        this.morada = morada;
        this.metodoEnvio = metodoEnvio;
        this.entregadora = entregadora;
        this.estadoEntrega = estadoEntrega;
        this.peso = this.pedido.getCarrinho().pesoTotal();
    }
    
    public Pedido getPedido() 
    {
        return this.pedido;
    }
    
    public String getMorada()
    {
        return this.morada;
    }
    
    public void setMorada(String password)
    {
        this.morada = morada;
    }
    
    public String getMetodoEnvio()
    {
        return this.metodoEnvio;
    }
    
    public String getEntregadora()
    {
        return this.entregadora;
    }
    
    public Estado getEstadoEntrega()
    {
        return this.estadoEntrega;
    }
}
