<div class="modal fade" id="update_provider{{ $proveedor->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white fw-bold">
                <p class="modal-title" id="exampleModalLabel">Editar información proveedor</p>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route("proveedor.update", ['proveedor' => $proveedor]) }}" novalidate autocomplete="off">
                    @method("PUT")
                    @csrf
                    <!-- Provider contact name & phone -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z\s]/g, '')" class="form-control @error('provider_contact_name') is-invalid @enderror" id="provider_contact_name"
                                    name="provider_contact_name" value="{{ $proveedor->provider_contact_name }}">
                                <label class="form-label" for="provider_contact_name">Nombre encargado <span class="text-danger">*</span></label>
                                @error('provider_contact_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" class="form-control @error('provider_contact_phone') is-invalid @enderror" id="provider_contact_phone"
                                    name="provider_contact_phone" value="{{ $proveedor->provider_contact_phone }}" maxlength="8">
                                <label class="form-label" for="provider_contact_phone">Teléfono encargado <span class="text-danger">*</span></label>
                                @error('provider_contact_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Provider company name -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9 ]/g, '')" class="form-control @error('provider_company_name') is-invalid @enderror" id="provider_company_name"
                                    name="provider_company_name" value="{{ $proveedor->provider_company_name }}">
                                <label class="form-label" for="provider_company_name">Nombre empresa <span class="text-danger">*</span></label>
                                @error('provider_company_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Provider company phone & R.T.N -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" class="form-control @error('provider_company_phone') is-invalid @enderror" id="provider_company_phone"
                                    name="provider_company_phone" value="{{ $proveedor->provider_company_phone }}" maxlength="8">
                                <label class="form-label" for="provider_company_phone">Teléfono empresa <span class="text-danger">*</span></label>
                                @error('provider_company_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" class="form-control @error('provider_company_rtn') is-invalid @enderror" id="provider_company_rtn"
                                    name="provider_company_rtn" value="{{ $proveedor->provider_company_rtn }}" maxlength="14">
                                <label class="form-label" for="provider_company_rtn">R.T.N <span class="text-danger">*</span></label>
                                @error('provider_company_rtn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Provider company address -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea oninput="this.value = this.value.toUpperCase()" class="form-control @error('provider_company_address') is-invalid @enderror" id="provider_company_address" name="provider_company_address"
                                    maxlength="255" style="resize: none; height: 100px; font-size: clamp(0.7rem, 3vh, 0.8rem);">{{ $proveedor->provider_company_address }}</textarea>
                                <label class="form-label" for="provider_company_address">Dirección empresa <span class="text-danger">*</span></label>
                                @error('provider_company_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit buttons -->
                    <div class="row">
                        <div class="col">
                            <a href="#" data-dismiss="modal" class="btn btn-sm btn-dark">
                                {{ __('Regresar') }}
                            </a>
                            <button type="submit" class="btn btn-sm btn-warning text-white">
                                {{ __('Guardar cambios') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>