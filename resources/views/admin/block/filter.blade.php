<div class="filter_block">
    <div class="admin_filtre">
        <form action="{{route('findproducts')}}" method="get">
            <label>Cautare:</label>
            <input type="text" name="query" required>
            <button type="submit">Go</button>
        </form>
    </div>
</div>
