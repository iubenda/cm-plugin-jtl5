<form class="card" action="{$action}" method="post">
    {$jtl_token}

    <div class="card-body">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">CMP Code-ID</span>
                </div>
                <input type="text" required name="consent_manager_id" value="{$consent_manager_id}" class="form-control"
                       placeholder="CMP Code-ID" aria-describedby="basic-addon1">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Code type</span>
                </div>
                <select name="code_type" id="" class="form-control">
                    <option value="1"{if $code_type == 1} selected{/if}>Automatic</option>
                    <option value="2"{if $code_type == 2} selected{/if}>Semi-automatic</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="additional_code">Additional code</label>
            <textarea name="additional_code" id="additional_code"
                      class="form-control"
                      cols="30" rows="10">{$additional_code}</textarea>
        </div>
    </div>
    <div class="card-footer text-right">
        <button class="btn btn-primary"><i
                    class="fa fa-save"></i> Save
        </button>
    </div>

</form>
