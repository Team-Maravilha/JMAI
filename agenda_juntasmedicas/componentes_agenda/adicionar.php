<div class="row gy-6 mx-0">

    <!-- SELECIONAR REQUERIMENTO -->
    <div class="fv-row col-12 px-0 pe-xxl-3">
        <label class="form-label">Requerimento</label>
        <select name="hashed_id_requerimento" class="form-select form-select-solid" data-control="select2" data-placeholder="Selecione um Requerimento">
            <option></option>
            <option value="1">Requerimento 1</option>
            <option value="2">Requerimento 2</option>
            <option value="3">Requerimento 3</option>
        </select>
    </div>

    <!-- SELECIONAR EQUIPA MÉDICA -->
    <div class="fv-row col-12 px-0 pe-xxl-3">
        <label class="form-label">Equipa Médica</label>
        <select name="hashed_id_equipa_medica" class="form-select form-select-solid" data-control="select2" data-placeholder="Selecione uma Equipa Médica">
            <option></option>
            <option value="1">Equipa Médica 1</option>
            <option value="2">Equipa Médica 2</option>
            <option value="3">Equipa Médica 3</option>
        </select>
    </div>

    <div class="fv-row col-12 px-0 pe-xxl-3">
        <label class="form-label d-flex align-items-center gap-2">
            Duração
            <span data-bs-toggle="tooltip" data-bs-html="true" title="Formatação feita em <b>Horas e Minutos</b>"></span>
        </label>
        <input type="text" name="duration" class="form-control form-control-solid" value="01:00" readonly />
    </div>



</div>