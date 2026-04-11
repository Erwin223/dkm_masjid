<style>
    .website-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .website-title {
        font-size: 20px;
        font-weight: 600;
        color: #111;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .website-nav {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .website-nav a {
        padding: 9px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid #ddd;
        color: #555;
        background: #fff;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: 0.2s;
    }

    .website-nav a:hover {
        background: #f0fbf6;
        border-color: #0f8b6d;
        color: #0f8b6d;
    }

    .website-nav a.active {
        background: #0f8b6d;
        border-color: #0f8b6d;
        color: #fff;
    }

    @media(max-width: 600px) {
        .website-nav {
            flex-direction: column;
            gap: 8px;
        }

        .website-nav a {
            justify-content: center;
            width: 100%;
        }

        .website-title {
            font-size: 18px;
        }
    }
</style>
